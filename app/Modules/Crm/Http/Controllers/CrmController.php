<?php
namespace App\Modules\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\Product;
use App\Modules\Crm\Http\CustomerServiceType;
use App\Modules\Crm\Http\DefaultRate;
use App\Modules\Crm\Http\CustomerBillingPeriod;
use App\Modules\Crm\Http\CustomerServiceItem;
use App\Modules\Crm\Http\CustomerServiceRate;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Crm\Http\CustomerNote;
use App\Modules\Crm\Http\Invoice;
use App\Modules\Crm\Http\Country;
use App\Services\GoogleCalendar;
use App\Services\Browser;

use App\Modules\Crm\Http\CustomerLocationContact;

use App\Model\Config;

use App\Model\Role;
use App\Model\User;
use App\Model\UserDevice;
use Auth;
use URL;
use Datatables;
use Cookie;
use Session;

class CrmController extends Controller
{
    private $hourly = 'hourly';
    private $flate_fee = 'flate fee';
    private $project = 'project';

    public function index()
    {
        $route_delete = 'admin.crm.destroy';
        return view('crm::crm.index', compact('route_delete'));
    }

    function setSessionShowCusts(Request $request)
    {

        if ($request->show_custs) {
            Session::put('show_custs', $request->show_custs);
        }

        return 'ok';
    }

    public function ajaxDataIndex()
    {

        $date_format = Config::where('title', 'date_format')->first();

        if (!empty(Session::get('show_custs'))) {
            if (Session::get('show_custs')=='all') {
                $customers = Customer::with(['locations','locations.contacts']);
            }

            if (Session::get('show_custs')=='active') {
                $customers = Customer::with(['locations','locations.contacts'])->where('is_active', 1);
            }

            if (Session::get('show_custs')=='disabled') {
                $customers = Customer::with(['locations','locations.contacts'])->where('is_active', 0);
            }
        } else {
            $customers = Customer::with(['locations','locations.contacts']);
        }

        return Datatables::of($customers)

        ->addColumn('contact', function ($customer) {

             //$customer->locations //loop
             $return = '';
            foreach ($customer->locations as $location) {
                foreach ($location->contacts as $contact) {
                    if ($contact->is_poc) {
                        $return .=' <button type="button" class="btn bg-gray-active  btn-sm">
     <i class="fa fa-user"></i>
     <span>'.$contact->f_name.' '.$contact->l_name.'</span>
   </button>
   <button type="button" class="btn bg-gray-active  btn-sm">
    <i class="fa fa-phone"></i>
    <span>'.$contact->phone.'</span>
  </button>';
                    }
                }
            }

            return $return;
        })
        ->editColumn('created_at', function ($customer) use ($date_format) {

              return  date($date_format->key, strtotime($customer->created_at));
        })

        ->addColumn('locations', function ($customer) {


              return '<button type="button" class="btn bg-gray-active  btn-sm">

  <span>'.count($customer->locations).'</span>
</button>';
        })
        ->addColumn('status', function ($customer) {

            if ($customer->is_active) {
                return '<button type="button" class="btn bg-green-active  btn-sm">
  <span>Active</span>
</button>';
            } else {
                return '<button type="button" class="btn bg-gray-active  btn-sm">
<span>Disable</span>
</button>';
            }
        })
        ->setRowId('id')
        ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $def_rates_ = DefaultRate::all();
        $def_rates = [];
        foreach ($def_rates_ as $def_rate) {
            $def_rates[$def_rate->title.'|'.$def_rate->amount] =$def_rate->title.' ($'.$def_rate->amount.')';
        }

        $service_items = CustomerServiceType::all();
        $service_types = [];
        foreach ($service_items as $service_item) {
            $service_types[$service_item->id] =$service_item->title;
        }

        $countries_ = Country::all();
        $countries = [];
        foreach ($countries_ as $country) {
            $countries[$country->name] =$country->name;
        }


        $billing_periods = CustomerBillingPeriod::all();
        $billing_arr = [];
        foreach ($billing_periods as $billing_period) {
            $billing_arr[$billing_period->id] =$billing_period->title;
        }

        $date_format = Config::where('title', 'date_format')->first();
        $time_format = Config::where('title', 'time_format')->first();

        return view('crm::crm.add', compact('service_types', 'billing_arr', 'countries', 'def_rates', 'date_format', 'time_format'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service_items = CustomerServiceType::all();
        $service_types = [];
        foreach ($service_items as $service_item) {
            $service_types[$service_item->id] =$service_item->title;
        }


        //1st step
        $customer                 = new Customer;
        $customer->name           = $request->customer_name;
        $customer->main_phone     = $request->phone;
        $customer->email_domain   = $request->email_domain;
        $customer->customer_since = date("Y-m-d", strtotime($request->customer_since));
        $customer->is_active      = $request->active;
        $customer->is_taxable     = $request->taxable;
        $customer->folder         = $this->generateGuid();
        $customer->save();


        //2nd step
        $service_item                  = new CustomerServiceItem;
        $service_item->service_type_id = $request->service_type_id;
        $service_item->title           = $request->service_item_name;
        $service_item->start_date      = date("Y-m-d", strtotime($request->start_date));
        $service_item->end_date        = date("Y-m-d", strtotime($request->end_date));

        $service_item->is_active       = $request->service_active;
        if (isset($request->service_default)) {
            $service_item->is_default      = $request->service_default;
        } else {
            $service_item->is_default      =0;
        }

        //if flate fee
        if (strtolower($service_types[$request->service_type_id])==$this->hourly || strtolower($service_types[$request->service_type_id])== $this->flate_fee) {
              $service_item->billing_period_id = $request->billing_period_id;
        }

        if (strtolower($service_types[$request->service_type_id])==$this->flate_fee) {
              $service_item->unit_price = $request->unit_price;
              $service_item->quantity  = $request->quantity;
        }

        if (strtolower($service_types[$request->service_type_id])==$this->project) {
              $service_item->estimate = $request->project_estimate;
              $service_item->estimated_hours = $request->estimated_hours;
              $service_item->bill_for = $request->bill_for;
        }
        //$service_item->save();
        $service_item->comments = $request->description_invoicing;
        $customer->service_items()->save($service_item);

        if ($request->default_rate) {
              $rate = new CustomerServiceRate;

              $default_rate_arr = explode('|', $request->default_rate);
              $default_rate_title = $default_rate_arr[0];
              $default_rate_amount = $default_rate_arr[1];

              $rate->title = $default_rate_title;
              $rate->amount = $default_rate_amount;
              $rate->status = 1;
              $service_item->rates()->save($rate);
        }
        if ($request->additional_rates) {
            foreach ($request->additional_rates as $additional_rate) {
                $additional_rate_obj = new CustomerServiceRate;

                $additional_rates_arr = explode('|', $additional_rate);
                /*$additional_rates[] = ['amount'=>$additional_rates_arr[1],
                'title'=>$additional_rates_arr[0]];*/
                $additional_rate_obj->title = $additional_rates_arr[0];
                $additional_rate_obj->amount = $additional_rates_arr[1];
                $additional_rate_obj->status = 1;


                $service_item->rates()->save($additional_rate_obj);
            }
        }





            $contacts_arr = json_decode($request->cntct_obj);
            $locations_arr = json_decode($request->loc_obj);
        //dd($locations_arr);
            $flag_default = true;
        foreach ($locations_arr as $location) {
            $location_obj                = new CustomerLocation;
            $location_obj->location_name = $location->location_name;
            $location_obj->address       = $location->address;
            $location_obj->country       = $location->country;
            $location_obj->state         = $location->state;
            $location_obj->city          = $location->city;
            $location_obj->zip           = $location->zip;
            $location_obj->phone         = $location->loc_main_phone;
            $location_obj->back_line_phone = $location->back_line_phone;
            $location_obj->primary_fax  = $location->primary_fax;
            $location_obj->secondary_fax  = $location->secondary_fax;


            if ($location->default_) {
                if ($flag_default) {
                    $location_obj->default       = $location->default_;
                    $flag_default = false;
                } else {
                    $location_obj->default       = 0;
                }
            } else {
                $location_obj->default       = 0;
            }


            $customer->locations()->save($location_obj);

            $flag_poc = true;
            foreach ($contacts_arr as $contact) {
                if ($contact->contact_location_index == $location->loc_id) {
                    $contact_obj         = new CustomerLocationContact;
                    $contact_obj->f_name = $contact->f_name;
                    $contact_obj->l_name = $contact->l_name;
                    $contact_obj->email  = $contact->email;
                    $contact_obj->title  = $contact->title_;
                    $contact_obj->phone  = $contact->contact_phone;
                    $contact_obj->mobile = $contact->contact_mobile;
                    if ($contact->contact_poc==1) {
                        if ($flag_poc) {
                            $contact_obj->is_poc = $contact->contact_poc;
                            $flag_poc = false;
                        } else {
                            $contact_obj->is_poc = 0 ;
                        }
                    } else {
                        $contact_obj->is_poc = $contact->contact_poc;
                    }

                    $location_obj->contacts()->save($contact_obj);
                }
            }
        }

            return redirect()->intended('admin/crm');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $customer = Customer::with(['service_items','locations','locations.contacts','service_items.rates',
        'service_items.service_type', 'products', 'notes','notes.entered_by','invoices' => function ($query) {
            $query->where('status', '!=', 'paid');
        }])
        ->where('id', $id)
        ->first();

        $countries_ = Country::all();
        $countries = [];
        foreach ($countries_ as $country) {
            $countries[$country->name] =$country->name;
        }


        //Global default rates application wise
        $def_rates_ = DefaultRate::all();
        $def_rates = [];
        foreach ($def_rates_ as $def_rate) {
             $def_rates[$def_rate->title.'|'.$def_rate->amount] =$def_rate->title.' ($'.$def_rate->amount.') (global)';
        }

        // Customer specific rates saved with service items
        foreach ($customer->service_items as $service_item) {
            foreach ($service_item->rates as $rate) {
                if ($rate->is_default==1 && $rate->status==1) {
                    $def_rates[$rate->title.'|'.$rate->amount] =$rate->title.' ($'.$rate->amount.')';
                }
            }
        }

        //rates for additional rates dropdown
        $additional_rates = [];

        foreach ($customer->service_items as $service_item) {
            foreach ($service_item->rates as $rate) {
                if ($rate->is_default==0 && $rate->status==1) {
                    $additional_rates[$rate->title.'|'.$rate->amount] =$rate->title.' ($'.$rate->amount.')';
                }
            }
        }

        $customer->invoices->overdue = 0;
        $customer->invoices->waiting = 0;
        foreach ($customer->invoices as $invoice) {
            if ($invoice->status == 'overdue') {
                $customer->invoices->overdue += $invoice->balance;
            }
            if ($invoice->status == 'sent') {
                $customer->invoices->waiting += $invoice->balance;
            }
        }

        // unset admin panel session key
        Session::forget('panel');

        Session::put('cust_id', $id);
        Session::put('customer_name', $customer->name);
        $products_db = Product::all();
        $products = [];
        foreach ($products_db as $product) {
                 $products[$product->id] =$product->name;
        }
        $assigned_products=[];
        foreach ($customer->products as $product) {
                 $assigned_products[] =$product->id;
        }


        $device_extention=[];
        $device_extention['saved']=0;
        $device_extention['extention']='';
        $data=UserDevice::where('cookie_id', Cookie::get('nexgen_device'))->first();

        if (count($data)>0) {
                  $device_extention['saved']=1;
                  $device_extention['extention']=$data->extention;
        }

        $employee = User::find(Auth::user()->id);


        $email_signature = $employee->email_signature;

        return view('crm::crm.show', compact(
            'customer',
            'service_types',
            'countries',
            'def_rates',
            'additional_rates',
            'products',
            'assigned_products',
            'email_signature',
            'device_extention'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->customer_del_id;
        $customer = Customer::with(['service_items','locations','locations.contacts','service_items.rates','service_items.service_type'])->where('id', $id)->first();

        foreach ($customer->locations as $location) {
            $location->contacts()->delete();
        }

        $customer->locations()->delete();

        foreach ($customer->service_items as $service_item) {
            $service_item->rates()->delete();
        }
        $customer->service_items()->delete();


        $customer->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        return redirect()->intended('admin/crm');
    }



    function ajaxAddProductTag(Request $request)
    {
        $customer = Customer::find($request->customer_id_for_tag);

        $customer->products()->sync($request->products);


        $return['success'] = 'ok';
         // $return['p_tags'] = 'Product added successfully';
        return (json_encode($return));
    }

    function ajaxDataLoad(Request $request)
    {
        $hourly = $this->hourly;
        $flate_fee = $this->flate_fee;
        $project = $this->project;

        $service_item = CustomerServiceType::find($request->id);
        $billing_periods = CustomerBillingPeriod::all();
        $billing_arr = [];
        foreach ($billing_periods as $billing_period) {
            $billing_arr[$billing_period->id] =$billing_period->title;
        }
        return view('crm::crm.service_item.ajax_service_item', compact('service_item', 'billing_periods', 'billing_arr', 'hourly', 'flate_fee', 'project'))->render();
    }

    function ajaxLoadLocation(Request $request)
    {
        $location = CustomerLocation::find($request->id)->toJson();
        return $location;
    }


    function ajaxListLocation($customer_id)
    {
        $locations =  CustomerLocation::where('customer_id', $customer_id)->get();

        return  view('crm::crm.location.ajax_refresh_locations', compact('locations', 'customer_id'))->render();

        exit;
    }


    function ajaxUpdateLocation(Request $request)
    {
        $this->validate(
            $request,
            [
            'location_name' => 'required',


            ]
        );
          //dd($request->all());
        $location_obj =  CustomerLocation::find($request->loc_id);

        $customer_id                 = $location_obj->customer_id;
        $location_obj->location_name = $request->location_name;
        $location_obj->address       = $request->address;
        $location_obj->country       = $request->country;
        $location_obj->state         = $request->state;
        $location_obj->city          = $request->city;
        $location_obj->zip           = $request->zip;
        $location_obj->alarm_code    = $request->alarm_code;
        $location_obj->door_code     = $request->door_code;
        $location_obj->notes         = $request->notes;
        $location_obj->phone         = $request->loc_main_phone;
        $location_obj->back_line_phone = $request->back_line_phone;
        $location_obj->primary_fax  = $request->primary_fax;
        $location_obj->secondary_fax  = $request->secondary_fax;
        if ($request->default) {
              CustomerLocation::where('customer_id', $customer_id)->update(['default'=>0]);
              $location_obj->default       = $request->default;
        }


        $location_obj->save();



        $arr['success'] = 'Location updated successfully';
        return json_encode($arr);
        exit;
    }

    function ajaxLoadContact(Request $request)
    {
            //echo $request->id;
        $data['contact'] = CustomerLocationContact::find($request->cntct_id);

            //echo $data['contact'];
        $data['locations'] = CustomerLocation::where('customer_id', $request->customer_id)->get();
        return json_encode($data);
        exit;
    }



    function ajaxUpdateContact(Request $request)
    {
        $this->validate(
            $request,
            [
            'f_name' => 'required',


            ]
        );
            //dd($request->all());
        $contact_obj =  CustomerLocationContact::find($request->cntct_id);


        $contact_obj->f_name               = $request->f_name;
        $contact_obj->l_name               = $request->l_name;
        $contact_obj->customer_location_id = $request->location_index;
        $contact_obj->email                = $request->email;
        $contact_obj->address       = $request->address;
        $contact_obj->country       = $request->country;
        $contact_obj->state         = $request->state;
        $contact_obj->city          = $request->city;
        $contact_obj->zip           = $request->zip;
        $contact_obj->title                = $request->title;
        $contact_obj->phone                = $request->contact_phone;
        $contact_obj->phone_ext            = $request->phone_ext;
        $contact_obj->mobile               = $request->contact_mobile;
        if ($request->primary_poc) {
              $cust_loc = CustomerLocation::find($request->location_index);
              $cust_locations = CustomerLocation::where('customer_id', $cust_loc->customer_id)->get();
            foreach ($cust_locations as $customer_loc) {
                CustomerLocationContact::where('customer_location_id', $customer_loc->id)->update(['is_poc'=>0]);
            }

              $contact_obj->is_poc               = 1;
        }

        $contact_obj->save();

        $arr['success'] = 'Contact updated sussessfully';
        return json_encode($arr);
        exit;
    }

    function ajaxRefreshContacts($customer_id)
    {

        $customer = Customer::with(['locations','locations.contacts'])->where('id', $customer_id)->first();


        return view('crm::crm.contact.ajax_refresh_location_contacts', compact('customer'))->render();

        exit;
    }


    function ajaxLoadInfo($id)
    {

        $customer = Customer::find($id);


        $data['customer_name']  = $customer->name;
        $data['phone']          = $customer->main_phone;
        $data['email_domain']   = $customer->email_domain;
        $data['customer_since'] = date('m/d/Y', strtotime($customer->customer_since));
        $data['credit_limit']     = $customer->credit_limit;
        $data['is_taxable']     = $customer->is_taxable;
        $data['is_active']      = $customer->is_active;

        return json_encode($data);
        //return json_encode($data);
        exit;
    }


    function ajaxUpdateInfo(Request $request)
    {
        $this->validate(
            $request,
            [
            'customer_name' => 'required',


            ]
        );

        $customer                 = Customer::find($request->c_id);
        $customer->name           = $request->customer_name;
        $customer->main_phone     = $request->phone;
        $customer->email_domain   = $request->email_domain;
        $customer->customer_since = date("Y-m-d", strtotime($request->customer_since));
        $customer->credit_limit   = $request->credit_limit;
        $customer->is_active      = $request->active;
        if ($request->taxable) {
            $customer->is_taxable     = 1;
        } else {
            $customer->is_taxable     = 0;
        }
        $customer->save();

        $arr['success']           = 'Customer info updated successfully';
        return json_encode($arr);
        exit;
    }

    function ajaxRefreshInfo($id)
    {

        $customer = Customer::find($id);

        $view = view('crm::crm.info.ajax_refresh_info', compact('customer'));
        $data['html_content'] =(string) $view;
        $data['h1_title'] = $customer->name;

        return json_encode($data);

        exit;
    }


    function ajaxAddLocation(Request $request)
    {

        $this->validate(
            $request,
            [
            'location_name' => 'required',


            ]
        );


        $location_obj                = new CustomerLocation;
        $location_obj->location_name = $request->location_name;
        $location_obj->address       = $request->address;
        $location_obj->country       = $request->country;
        $location_obj->state         = $request->state;
        $location_obj->city          = $request->city;
        $location_obj->zip           = $request->zip;
        $location_obj->phone         = $request->loc_main_phone;
        $location_obj->alarm_code    = $request->alarm_code;
        $location_obj->door_code     = $request->door_code;
        $location_obj->notes         = $request->notes;
        $location_obj->back_line_phone = $request->back_line_phone;
        $location_obj->primary_fax  = $request->primary_fax;
        $location_obj->secondary_fax  = $request->secondary_fax;
        if ($request->default) {
            $location_obj->default       = 1;
        } else {
            $location_obj->default       =0;
        }
        $location_obj->customer_id   = $request->customer_id;

        $location_obj->save();


        $customer_id = $request->new_loc_customer_id;

        $arr['success'] = 'Location added successfully';
        return json_encode($arr);
        exit;
    }

    function ajaxDeleteLocation(Request $request)
    {
        $location = CustomerLocation::find($request->id);
        $location->delete();
        $arr['success'] = 'Location removed.';
        return json_encode($arr);
        exit;
    }

    // Old function
    function ajaxGetLocationsList($cust_id)
    {
        $data['locations'] = CustomerLocation::where('customer_id', $cust_id)->get();
        return json_encode($data);
        exit;
    }

    function ajaxAddContact(Request $request)
    {
         // dd($request->all());
        $this->validate(
            $request,
            [
            'f_name' => 'required',
            ]
        );

              //dd($request->all());
        $contact_obj                       =  new CustomerLocationContact;

        $contact_obj->f_name               = $request->f_name;
        $contact_obj->l_name               = $request->l_name;
        $contact_obj->customer_location_id = $request->location_index;
        $contact_obj->email                = $request->email;
        $contact_obj->title                = $request->title;
        $contact_obj->phone                = $request->contact_phone;
        $contact_obj->phone_ext            = $request->phone_ext;
        $contact_obj->mobile               = $request->contact_mobile;

        $contact_obj->address       = $request->address;
        $contact_obj->country       = $request->country;
        $contact_obj->state         = $request->state;
        $contact_obj->city          = $request->city;
        $contact_obj->zip           = $request->zip;

        if ($request->primary_poc) {
            $contact_obj->is_poc               = 1;
        } else {
            $contact_obj->is_poc               = 0;
        }
        $contact_obj->save();

        $arr['success']                    = 'Contact Added sussessfully';
        return json_encode($arr);
        exit;
    }


    function ajaxListServiceItem($customer_id)
    {

        $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();

        return  view('crm::crm.service_item.ajax_refresh_service_items', compact('service_items', 'customer_id'))->render();

        exit;
    }

    function ajaxLoadServiceItem(Request $request)
    {
        $service_item = CustomerServiceItem::where('id', $request->srvc_item_id)->with(['rates','service_type','billing_period'])->first();

        $service_items = CustomerServiceType::all();

        $hourly = $this->hourly;
        $flate_fee = $this->flate_fee;
        $project = $this->project;


        $billing_periods = CustomerBillingPeriod::all();
        $service_types = [];
        foreach ($service_items as $service_item_obj) {
            $service_types[$service_item_obj->id] =$service_item_obj->title;
        }

        $billing_arr = [];
        foreach ($billing_periods as $billing_period) {
            $billing_arr[$billing_period->id] =$billing_period->title;
        }



        $view = view('crm::crm.service_item.ajax_load_service_item', compact('service_item', 'service_types', 'hourly', 'flate_fee', 'project', 'billing_arr'))->render();

        $arr['view_srvc_itm'] = (string) $view;

        return json_encode($arr);
        exit;
    }

    function ajaxUpdateServiceItem(Request $request)
    {
        //dd($request->all());

         $service_items                    = CustomerServiceType::all();
         $service_types                    = [];
        foreach ($service_items as $service_item) {
            $service_types[$service_item->id] =$service_item->title;
        }

        $service_item                     = CustomerServiceItem::find($request->service_item_id);
        $service_item->service_type_id    = $request->service_type_id;
        $service_item->title              = $request->service_item_name;
        $service_item->start_date         = date("Y-m-d", strtotime($request->start_date));
        $service_item->end_date           = date("Y-m-d", strtotime($request->end_date));

        $service_item->is_active = $request->service_active;
        if ($request->service_default) {
            $service_item->is_default = 1;
        } else {
            $service_item->is_default =0;
        }

           //if flate fee
        if (strtolower($service_types[$request->service_type_id])==$this->hourly || strtolower($service_types[$request->service_type_id])== $this->flate_fee) {
             $service_item->billing_period_id = $request->billing_period_id;
        }

        if (strtolower($service_types[$request->service_type_id])==$this->flate_fee) {
             $service_item->unit_price = $request->unit_price;
             $service_item->quantity  = $request->quantity;
        }

        if (strtolower($service_types[$request->service_type_id])==$this->project) {
             $service_item->estimate = $request->project_estimate;
             $service_item->estimated_hours = $request->estimated_hours;
             $service_item->bill_for = $request->bill_for;
        }
        //$service_item->save();
        //$service_item->comments = $request->description_invoicing;

        $customer_id = $service_item->customer_id;

        $service_item->save();


        CustomerServiceRate::where('customer_service_item_id', $request->service_item_id)->delete();
        //$billing_period->delete();
        //Session::flash('flash_message', 'User successfully deleted!');

        $rate = new CustomerServiceRate;

        $default_rate_arr     = explode('|', $request->default_rate);
        $default_rate_title   = $default_rate_arr[0];
        $default_rate_amount  = $default_rate_arr[1];


        $rate->title = $default_rate_title;
        $rate->amount = $default_rate_amount;

        $rate->is_default = 1;
        $rate->status = 1;
        $service_item->rates()->save($rate);

        if ($request->additional_rates) {
            foreach ($request->additional_rates as $additional_rate) {
                $additional_rate_obj = new CustomerServiceRate;

                $additional_rates_arr = explode('|', $additional_rate);
                   /*$additional_rates[] = ['amount'=>$additional_rates_arr[1],
                   'title'=>$additional_rates_arr[0]];*/
                   $additional_rate_obj->title = $additional_rates_arr[0];
                   $additional_rate_obj->amount = $additional_rates_arr[1];
                   $additional_rate_obj->status =1;

                   $service_item->rates()->save($additional_rate_obj);
            }
        }





                $arr['success'] = 'Service Type Updated sussessfully';
                return json_encode($arr);
                exit;
    }


    function ajaxListRate($customer_id)
    {
        $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();

        return  view('crm::crm.rate.ajax_refresh_service_item_rates', compact('service_items'))->render();

        exit;
    }


    function ajaxLoadRate($id)
    {
        $rate =  CustomerServiceRate::find($id);

        return json_encode($rate);
        exit;
    }

    function ajaxUpdateRate(Request $request)
    {
        $rate = CustomerServiceRate::find($request->rate_id);

        $rate->title = $request->title;
        $rate->amount = $request->amount;
        if ($request->default) {
            $rate->is_default = 1;
        } else {
            $rate->is_default=0;
        }

        if ($request->status) {
            $rate->status = 1;
        } else {
            $rate->status = 0;
        }
        $rate->save();
        $service_item_id = $request->servc_item_id_rate;

        $service_item =  CustomerServiceItem::find($service_item_id);
        $customer_id = $service_item->customer_id;

        $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();

        $arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates', compact('service_items'))->render();



        $arr['success'] = 'Service Type rate Updated sussessfully';

        return json_encode($arr);
        exit;
    }

    function ajaxAddRate(Request $request)
    {
        //dd($request->all());
        $service_item_id = $request->servc_item_id_new_rate;
        //dd($service_item_id );
        $rate = new CustomerServiceRate;

        $rate->title = $request->title;
        $rate->amount = $request->amount;
        $rate->customer_service_item_id = $service_item_id;
        if ($request->default) {
            //dd('lll');
            $rate->is_default = 1;
            /*$change_rate = CustomerServiceRate::where('customer_service_item_id',$service_item_id)->first();
            $change_rate->is_default = 0;
            $change_rate->save();*/
        } else {
            $rate->is_default=0;
        }

        if ($request->status) {
            $rate->status = 1;
        } else {
            $rate->status = 0;
        }
        $rate->save();

        $service_item =  CustomerServiceItem::find($service_item_id);
        $customer_id = $service_item->customer_id;

        $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();
//$rates = CustomerServiceRate::where('customer_service_item_id',$service_item_id)->get();
        $arr['success'] = 'Service Type rate Added sussessfully';
        $arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates', compact('service_items'))->render();
        return json_encode($arr);
        exit;
    }



    function ajaxLoadNewServiceItem($cust_id)
    {

        $hourly = $this->hourly;
        $flate_fee = $this->flate_fee;
        $project = $this->project;
        $service_types_arr = CustomerServiceType::all();
        $service_types = [];
        foreach ($service_types_arr as $service_type_obj) {
             $service_types[$service_type_obj->id] =$service_type_obj->title;
        }

        $arr['service_types'] = $service_types;
        return json_encode($arr);
        exit;
        //dd($cust_id);
    }

    function ajaxAddServiceItem(Request $request)
    {
        $this->validate(
            $request,
            [
            'service_type_id' => 'required',
            'default_rate'     =>'required'


            ]
        );
        $service_types_data                                      = CustomerServiceType::all();
        $service_types                                           = [];
        foreach ($service_types_data as $service_item) {
            $service_types[$service_item->id]                        =$service_item->title;
        }

        $service_item                                            = new CustomerServiceItem;
        $service_item->service_type_id                           = $request->service_type_id;
        $service_item->title                                     = $request->service_item_name;
        $service_item->start_date                                = date("Y-m-d", strtotime($request->start_date));
        $service_item->end_date                                  = date("Y-m-d", strtotime($request->end_date));

        $service_item->customer_id                               = $request->customer_id_new_service_item;

        $service_item->is_active                                 = $request->service_active;
        if (isset($request->service_default)) {
            $service_item->is_default                                = $request->service_default;
        } else {
            $service_item->is_default                                =0;
        }

      //if flate fee
        if (strtolower($service_types[$request->service_type_id]) ==$this->hourly || strtolower($service_types[$request->service_type_id])== $this->flate_fee) {
            $service_item->billing_period_id                         = $request->billing_period_id;
        }

        if (strtolower($service_types[$request->service_type_id]) ==$this->flate_fee) {
            $service_item->unit_price                                = $request->unit_price;
            $service_item->quantity                                  = $request->quantity;
        }

        if (strtolower($service_types[$request->service_type_id]) ==$this->project) {
            $service_item->estimate                                  = $request->project_estimate;
            $service_item->estimated_hours                           = $request->estimated_hours;
            $service_item->bill_for                                  = $request->bill_for;
        }

        $service_item->save();



        $rate = new CustomerServiceRate;

        $default_rate_arr     = explode('|', $request->default_rate);
        $default_rate_title   = $default_rate_arr[0];
        $default_rate_amount  = $default_rate_arr[1];


        $rate->title = $default_rate_title;
        $rate->amount = $default_rate_amount;
        $rate->is_default = 1;
        $rate->status = 1;
        $service_item->rates()->save($rate);

        if ($request->additional_rates) {
            foreach ($request->additional_rates as $additional_rate) {
                $additional_rate_obj = new CustomerServiceRate;

                $additional_rates_arr = explode('|', $additional_rate);

                $additional_rate_obj->title = $additional_rates_arr[0];
                $additional_rate_obj->amount = $additional_rates_arr[1];
                $additional_rate_obj->status =1;

                $service_item->rates()->save($additional_rate_obj);
            }
        }


        $customer_id = $request->customer_id_new_service_item;
        $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $request->customer_id_new_service_item)->get();


        $arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates', compact('service_items'))->render();


        $arr['html_contents'] =  view('crm::crm.service_item.ajax_refresh_service_items', compact('service_items', 'customer_id'))->render();

        $arr['success'] = 'Service Item added sussessfully';
        return json_encode($arr);
        exit;
    }


    function ajaxDeleteContact(Request $request)
    {
        $contact = CustomerLocationContact::find($request->id);
        $contact->delete();

        $arr['success'] = 'Contact deleted sussessfully';
        return json_encode($arr);
        exit;
    }

    function ajaxDeleteRate($rate_id, $service_item_id)
    {


        //dd($service_item_id );
        $rate =  CustomerServiceRate::find($rate_id);


        $rate->delete();


        $service_item =  CustomerServiceItem::find($service_item_id);
        $customer_id = $service_item->customer_id;

        $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();

        $arr['success'] = 'Service Type rate Deleted sussessfully';
        $arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates', compact('service_items'))->render();
        return json_encode($arr);


        exit;
    }

    // Click to call functionality
    function ajaxClicktoCall($number, $exten, $customer_id, $save)
    {

        $browser = new Browser();



        if ($save == 'true') {
            $saved_devices = UserDevice::where('user_id', Auth::user()->id)->count();
            $update=1;
            if (Cookie::get('nexgen_device')) {
                 $count=UserDevice::where('cookie_id', Cookie::get('nexgen_device'))->count();
                if ($count==0) {
                    Cookie::forget('nexgen_device');
                } else {
                    $update = 0;
                }
            }
         //check if devices are less then 5 for a specific user
            if ($saved_devices < 5 && $update == 1) {
                  $cookie_id = MD5($browser->getUserAgent().time());

                  Cookie::queue("nexgen_device", $cookie_id, 2147483647);
                  $device = new UserDevice;
                  $device->user_id   = Auth::user()->id;
                  $device->extention = $exten;
                  $device->brower_name = $browser->getBrowser();
                  $device->operating_system = $browser->getPlatform();
                  $device->cookie_id = $cookie_id;
                  $device->save();
            }
        }
        $customer=Customer::find($customer_id);

        $number = preg_replace('/[^\d]/', '', $number);
        $url = 'https://ng.ngvoip.us/app/click_to_call/click_to_call.php?username=netpro25&password=ZpDGCsapr4MDcPsV&src_cid_name='.urlencode($customer->name).'&src_cid_number='.$number.'&dest_cid_name=NexgenTec&dest_cid_number=3522243866&auto_answer=true&rec=false&ringback=us-ring&src='.$exten .'&dest='.$number;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_exec($ch);
    }

    function ajaxDeleteServiceItem($s_id, $customer_id)
    {


        //dd($service_item_id );
        CustomerServiceItem::where('id', $s_id)->delete();
        CustomerServiceRate::where('customer_service_item_id', $s_id)->delete();



        $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();


        $arr['html_contents'] =  view('crm::crm.service_item.ajax_refresh_service_items', compact('service_items', 'customer_id'))->render();

        $arr['success'] = 'Service Item deleted sussessfully';
        return json_encode($arr);
        exit;
    }

    function ajaxGetServiceItems($c_id)
    {
        $customer = Customer::with(['service_items','locations','service_items.rates','service_items.service_type'])->where('id', $c_id)->first();

        $arr['locations'] = $customer->locations;
        $arr['service_items'] = $customer->service_items;

        return json_encode($arr);
        exit;
    }


    /**
     * Return calendar events
     */
    function ajaxCalGetEvents(Request $request)
    {
        $calendar = new GoogleCalendar;
        $events_result = $calendar->eventList($request->start, $request->end);
        $events_arr = [];

        foreach ($events_result->getItems() as $event) {
            if ($event->start->getDatetime()!=null) {
                $events_arr[] = ['title'=>$event->getSummary(),
                'start'=>$event->start->getDatetime(),
                'end'=>$event->end->getDatetime()];
            } else {
                $events_arr[] = ['title'=>$event->getSummary(),
                'start'=>$event->start->getDate(),
                'end'=>$event->end->getDate()];
            }
        }
        return json_encode($events_arr);
        exit;
    }

    // Angular
    function angularList($id = null)
    {
        if ($id == null) {
            return Customer::with(['contacts'])->orderBy('id', 'asc')->get();
        } else {
            dd($this->show($id));
        }
    }


    function searchCustomers(Request $request)
    {
    //dd($request->all());
        if ($request->cust) {
            $customers_result = Customer::with(['locations','locations.contacts'])->where('name', 'like', '%'.$request->cust.'%')->get();

            $customers = [];
            foreach ($customers_result as $customer) {
                $customers[] = ['id'=>$customer->id,'cust_name'=>$customer->name];
            }

            echo json_encode(array(
            "status" => true,
            "error"  => null,
            "data"   => array(
            "customers"   => $customers
            )
            ));
        } else {
            echo json_encode(array(
            "status" => true,
            "error"  => null,
            "data"   => array(
            "customers"   => []
            )
            ));
        }
    }

    function searchLocations(Request $request)
    {
        //dd($request->all());
        if ($request->loc) {
             $locations_result = CustomerLocation::with('customer')->where('location_name', 'like', '%'.$request->loc.'%')->get();



             $locations = [];
            foreach ($locations_result as $location) {
               //dd($location->customer);
                $locations[] = ['id'=>$location->customer->id,
                'loc_name'=>$location->location_name.' ('.$location->customer->name.')'];
            }

             echo json_encode(array(
              "status" => true,
              "error"  => null,
              "data"   => array(
                "locations"   => $locations
              )
              ));
        } else {
            echo json_encode(array(
            "status" => true,
            "error"  => null,
            "data"   => array(
            "locations"   => []
            )
            ));
        }
    }


    function searchLocationContacts(Request $request)
    {
        //dd($request->all());
        if ($request->c_contact) {
            $locations_result = CustomerLocation::with(['customer','contacts'=>function ($query) use ($request) {

                $query->where('f_name', 'like', '%'.$request->c_contact.'%')->orWhere('l_name', 'like', '%'.$request->c_contact.'%');
            }])->get();



            $contacts = [];
            foreach ($locations_result as $location) {
                foreach ($location->contacts as $loc_contact) {
                    $contacts[] = ['id'=>$location->customer->id,
                    'cust_contact'=>$loc_contact->f_name.' '.$loc_contact->l_name.' ('.$location->customer->name.')'];
                }
                //dd($location->customer);
            }

            echo json_encode(array(
            "status" => true,
            "error"  => null,
            "data"   => array(
            "cust_contacts"   => $contacts
            )
            ));
        } else {
            echo json_encode(array(
            "status" => true,
            "error"  => null,
            "data"   => array(
            "cust_contacts"   => []
            )
            ));
        }
    }



    function listAjaxActiveCustomers()
    {
          $customers = Customer::where('is_active', 1)->get();

          return json_encode(['customers'=>$customers]);
    }

    private function generateGuid()
    {
          $s = strtoupper(md5(uniqid(rand(), true)));
          $guidText =
          substr($s, 0, 8) . '-' .
          substr($s, 8, 4) . '-' .
          substr($s, 12, 4). '-' .
          substr($s, 16, 4). '-' .
          substr($s, 20);
          return $guidText;
    }
}
