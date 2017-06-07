<?php
namespace App\Modules\Vendor\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerLocation;
use Datatables;
use App\Modules\Vendor\Http\Vendor;
use App\Modules\Vendor\Http\VendorContact;
use App\Modules\Vendor\Http\VendorCustomer;

//use App\Modules\Vendor\Http\VendorCustomerLocation;

use App\Modules\Assets\Http\KnowledgePassword;
use App\Modules\Assets\Http\Tag;
use App\Model\Role;
use App\Model\User;
use Illuminate\Support\Facades\DB;
use Auth;
use Mail;
use URL;
use Session;
use App\Model\Config;

class VendorController extends Controller
{

    public function index()
    {

        $customers_obj = Customer::with(['locations','locations.contacts'])->where('is_active', 1)->get();
            //$asset_roles_obj = AssetRole::all();
            $customers = [];

        if ($customers_obj->count()) {
            foreach ($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';



                //dd($user->id);
            }
        }
//dd($locations);

        return view('vendor::index', compact('customers'));
        //return "Controller Index";
    }


    function vendorsIndex($id = null)
    {
        $global_date = $this->global_date;

        if (!empty(Session::get('cust_id'))) {
            $vendors = Vendor::with(['customers'])->whereHas('customers', function ($query) {
                $query->where('customer_id', Session::get('cust_id'));
            });
        } else {
            $vendors = Vendor::orderBy('created_at', 'desc')->get();
            //dd($vendors);
        }
    //dd($vendors->get());
        return Datatables::of($vendors)

            ->addColumn('action', function ($vendor) {
                if (!empty(Session::get('cust_id'))) {
                    $return = '<div class="btn-group">';

                    if (!empty(Session::get('cust_id'))) {
                        $return .= '<button type="button" class="btn btn-xs edit "
                      data-toggle="modal" data-id="'.Session::get('cust_id').'" data-vendor_id="'.$vendor->id.'"id="modaal" data-target="#modal-edit-customer">
                      <i class="fa fa-edit " ></i></button>';
                    } else {
                        $return .= '<button type="button" class="btn btn-xs edit "
                      data-toggle="modal" data-id="'.$vendor->id.'" id="modaal" data-target="#modal-edit-customer">
                      <i class="fa fa-edit " ></i></button>';
                    }
                            $return .=' <button type="button" class="btn btn-danger btn-xs"
												data-toggle="modal" data-id="'.$vendor->customers[0]->pivot->id.'" id="modaal" data-target="#modal_vendor_customer_unlink">
											<i class="fa fa-times-circle"></i></button></div>';
                               $return .= '</div>';

                               return $return;
                }
            })
            ->editColumn('created_at', function ($vendor) use ($global_date) {
                return  date($global_date, strtotime($vendor->created_at));
            })
        ->addColumn('customer', function ($vendor) use ($global_date) {
            $return ='';
            foreach ($vendor->customers as $customer) {
                $return .=' <button class="btn bg-gray-active  btn-sm" type="button">
	                <i class="fa fa-user"></i>
	                <span>'.$customer->name.'</span>
	                </button>';
            }
            return  $return ;
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

        $customers_obj = Customer::with(['locations','locations.contacts'])->where('is_active', 1)->get();
        //$asset_roles_obj = AssetRole::all();
        $customers = [];
        if ($customers_obj->count()) {
            foreach ($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                //dd($user->id);
            }
        }


         return view('vendor::add', compact('customers'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //dd($request->all());
            //dd(json_decode($request->cust_arr));

            $contact_arr =  json_decode($request->contact_arr);
            $cust_arr   =  json_decode($request->cust_arr);
            $business_hours_arr =  json_decode($request->business_hours);


            //dd(count($contact_arr));
        if ($request->vendor_flag=='add') {
            $this->validate(
                $request,
                [
                    'name' => 'required',
                    //'customer' => 'required',


                 ]
            );



            $vendor = new Vendor;
            $vendor->name = $request->name ;
            $vendor->phone_number = $request->phone ;
            $vendor->dailing_instructions = $request->dialing_instructions ;
            $vendor->website = $request->website;
            $vendor->zip = $request->zip ;
            $vendor->address = $request->address ;
            $vendor->city = $request->city ;
            $vendor->state = $request->state ;
            $vendor->business_hours = $request->business_hours ;



            $vendor->save();
            /*
              $kpass = new KnowledgePassword();
              $kpass->login = $request->user_name;
              $kpass->password = $request->password;
              $kpass->customer_id = $request->customer;

              $asset->password()->save($kpass);*/


            if (count($contact_arr)>0) {
                foreach ($contact_arr as $contact) {
                    $vandor_contact = new VendorContact;
                    $vandor_contact->f_name = $contact->f_name;
                    $vandor_contact->l_name = $contact->l_name;
                    $vandor_contact->email  = $contact->email;
                    $vandor_contact->title  = $contact->title_;
                    $vandor_contact->phone  = $contact->contact_phone;
                    $vandor_contact->mobile = $contact->contact_mobile;



                    $vendor->contacts()->save($vandor_contact);
                }
            }
            foreach ($cust_arr as $customer) {
                $customer_ = Customer::with(['vendors'])->where('id', $customer->customer_selected_id)->first();
            //$customer->vendors()->detach();



                $vendor_customer = [];
                $vendor_customer['auth_contact_name']= $customer->auth_name;
                $vendor_customer['phone_number'] = $customer->phone;
                $vendor_customer['account_number']  = $customer->account_num;
                $vendor_customer['portal_url']  = $customer->portal_url;
            //$vendor_customer['portal_username']  = $customer->username;
            //$vendor_customer['portal_password'] = $customer->password;
                $vendor_customer['notes'] = $customer->notes;
            //$vandor_customer->customer_id = $customer->customer_selected_id;

                $vendor_cust_arr = [];

                $vendor_cust_arr[$vendor->id] = $vendor_customer;


            //$vandor_customer->customer_id = $customer->customer_selected_id;
           //dd($vendor_customer);

            /*$vpass = new KnowledgePassword();
            $vpass->login = $customer->user_name;
            $vpass->password = $customer->password;
            $vpass->customer_id = $customer->customer_selected_id;

            $vendor->password()->save($vpass);*/


                $customer_->vendors()->attach($vendor_cust_arr);
                //}



             //$vendor->customers()->attach($customer->customer_selected_id,$vendor_customer);
            }
        }

        if ($request->vendor_flag=='attach') {
            $vendor  = Vendor::find($request->vendor_id);
            //$vendor_ids = explode(',', $request->vendor_id);

            if (count($contact_arr)>0) {
                foreach ($contact_arr as $contact) {
                    $vandor_contact = new VendorContact;
                    $vandor_contact->f_name = $contact->f_name;
                    $vandor_contact->l_name = $contact->l_name;
                    $vandor_contact->email  = $contact->email;
                    $vandor_contact->title  = $contact->title_;
                    $vandor_contact->phone  = $contact->contact_phone;
                    $vandor_contact->mobile = $contact->contact_mobile;
                    $vendor->contacts()->save($vandor_contact);
                }
            }


            foreach ($cust_arr as $customer) {
                $customer_ = Customer::with(['vendors'])->where('id', $customer->customer_selected_id)->first();
                //$customer->vendors()->detach($vendor);

                $vendor_customer = [];
                $vendor_customer['auth_contact_name']= $customer->auth_name;
                $vendor_customer['phone_number'] = $customer->phone;
                $vendor_customer['account_number']  = $customer->account_num;
                $vendor_customer['portal_url']  = $customer->portal_url;
                $vendor_customer['portal_username']  = $customer->username;
                $vendor_customer['portal_password'] = $customer->password;
                $vendor_customer['notes'] = $customer->notes;
                //$vandor_customer->customer_id = $customer->customer_selected_id;

                $vendor_cust_arr = [];

                $vendor_cust_arr[$request->vendor_id] = $vendor_customer;

                /*$vpass = new KnowledgePassword();
                $vpass->login = $customer->user_name;
                $vpass->password = $customer->password;
                $vpass->customer_id = $customer->customer_selected_id;

                $vendor->password()->save($vpass);*/

                $customer_->vendors()->attach($vendor_cust_arr);
            }
        }
            $arr['success'] = 'yes';
            $arr['msg'] = 'Vendor added successfully';
            return json_encode($arr);
            //return redirect()->route('admin.vendors.index');

        //
    }


    public function destroy(Request $request)
    {
        $id = $request->vendor_id;
        $vendor = Vendor::where('id', $id)->first();

        $vendor->contacts()->delete();
        $vendor->customers()->detach();

       // $customer->locations()->delete();


        $vendor->delete();
        return redirect()->route('admin.vendors.index');
    }

    function updateInfo(Request $request)
    {
        $this->validate(
            $request,
            [
                        'name' => 'required',
                        //'customer' => 'required',
            ]
        );


                $business_hours_arr =  json_decode($request->business_hours);
                $vendor = Vendor::find($request->vendor_id);
                $vendor->name = $request->name ;
                $vendor->phone_number = $request->phone ;
                $vendor->dailing_instructions = $request->dialing_instructions ;
                $vendor->website = $request->website;
                $vendor->zip = $request->zip ;
                $vendor->address = $request->address ;
                $vendor->city = $request->city ;
                $vendor->state = $request->state ;
                $vendor->business_hours = $request->business_hours ;

                $vendor->save();
         $arr['success'] = 'Vendor info updated successfully';
            return json_encode($arr);
            exit;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       //dd( $dd );
         $date_format = Config::where('title', 'date_format')->first();
        // $vendor = Vendor::with(['customers'=>function($query){

        //   $query->join('customer_locations','')->wherePivot('location_id','=','customer_locations.id');

        // },'contacts'])->where('id',$id)->first();

        //$vendor = Vendor::with(['customers','customers.locations.vend_cust_loc','contacts'])->where('id',$id)->get();

          $vendor = Vendor::with(['customers'])->where('id', $id)->first();
        //dd($vendor);
           $customers_obj = Customer::with(['locations','locations.contacts'])->where('is_active', 1)->get();
            //$asset_roles_obj = AssetRole::all();
            $customers = [];
        if ($customers_obj->count()) {
            foreach ($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                //dd($user->id);
            }
        }


        //
        return view('vendor::show', compact('vendor', 'date_format', 'customers'));
    }

    public function ajaxDetails($id)
    {
        $cusid = Session::get('cust_id');
        /*$vendor = DB::table('customer_vendor AS cv')
        ->select(DB::raw('cv.customer_id, cv.vendor_id, v.id, v.name as v_name,
        v.phone_number as v_phone, v.dailing_instructions as v_dialins, v.website as v_website,
        v.address as v_address, v.city as v_city, v.state as v_state, v.zip as v_zip,
        v.business_hours as v_hours, cv.location_id, l.id, cv.auth_contact_name as cv_name,
        cv.phone_number as cv_phone, cv.account_number as cv_acctnum, cv.portal_url as cv_portal,
        cv.portal_username as cv_username, cv.portal_password as cv_pass, cv.notes, l.location_name,
        l.address as location_address, l.city as location_city, l.state as location_state,
        l.zip as location_zip, l.phone as location_phone'))
        ->join('vendors AS v', 'cv.vendor_id', '=', 'v.id')
        ->join('customer_locations as l', 'cv.location_id', '=', 'l.id')
        ->where('cv.customer_id','=',$cusid)->first();*/

       /* $vendor = DB::table('customer_vendor AS cv')
        ->select('cv.*')
        ->join('vendors AS v', 'cv.vendor_id', '=', 'v.id')
        ->join('customer_locations as l', 'cv.location_id', '=', 'l.id')
        ->where('cv.customer_id','=',$cusid)->first();*/

        // $vendor = Vendor::with(
        // 	['customers'=>
        // 		function($query) use($cusid) {
        //   		$query->wherePivot('customer_id','=',$cusid);
        // 		},
        // 	 'vend_cust_loc',
        // 	 'password'=>
        // 	 	function($query) use($cusid) {
        //   		$query->where('customer_id','=',$cusid);
        // 		}
        // 		])->where('id',$id)->first();

        $vendor = Vendor::with('vendorCustomerLocations.customer', 'vendorCustomerLocations.location')->where('id', $id)->first();

        if (count($vendor->vendorCustomerLocations->first()->customer->where('id', $cusid))) {
            $customer = $vendor->vendorCustomerLocations->first()->customer->where('id', $cusid)->first();
        } else {
            $customer = null;
        }
        $location = $vendor->vendorCustomerLocations->first()->location;

        return view('vendor::detail_partial', compact('customer', 'location', 'vendor'));
    }

    public function addContact(Request $request)
    {
        $this->validate(
            $request,
            [
                    'f_name' => 'required',
                    //'customer' => 'required',


            ]
        );

            $vandor_contact = new VendorContact;
             $vandor_contact->vendor_id = $request->vendor_id;
            $vandor_contact->f_name = $request->f_name;
            $vandor_contact->l_name = $request->l_name;
            $vandor_contact->email  = $request->email;
            $vandor_contact->title  = $request->title;
            $vandor_contact->phone  = $request->contact_phone;
            $vandor_contact->mobile = $request->contact_mobile;


           $vandor_contact->save();

            $arr['success'] = 'Contact Added successfully';
            return json_encode($arr);
            exit;
    }

    function editContact($id)
    {
          $contact = VendorContact::find($id);

          $arr['contact'] = $contact;
            return json_encode($arr);
            exit;
    }




    public function updateContact(Request $request)
    {
        $this->validate(
            $request,
            [
                'f_name' => 'required',
                //'customer' => 'required',


             ]
        );

        $vandor_contact = VendorContact::find($request->cntct_id);
         $vandor_contact->vendor_id = $request->vendor_id;
        $vandor_contact->f_name = $request->f_name;
        $vandor_contact->l_name = $request->l_name;
        $vandor_contact->email  = $request->email;
        $vandor_contact->title  = $request->title;
        $vandor_contact->phone  = $request->contact_phone;
        $vandor_contact->mobile = $request->contact_mobile;


        $vandor_contact->save();

        $arr['success'] = 'Contact updated successfully';
        return json_encode($arr);
        exit;
    }

    function destroyContact(Request $request)
    {
        $contact =  VendorContact::find($request->contact_id);
        $contact->delete();

         $arr['success'] = 'Contact deleted successfully';
            return json_encode($arr);
            exit;
    }

    public function addCustomer(Request $request)
    {
        $this->validate(
            $request,
            [
                    'customer_id' => 'required',
                    //'customer' => 'required',


            ]
        );

            $vendor_customer = new VendorCustomer;
             $vendor_customer->auth_contact_name = $request->auth_contact_name;
             $vendor_customer->vendor_id = $request->vendor_id;
             $vendor_customer->customer_id = $request->customer_id;
             $vendor_customer->location_id = $request->customer_location_id;
            $vendor_customer->phone_number  = $request->cust_phone;
            $vendor_customer->account_number   = $request->account_number;
            $vendor_customer->portal_url   = $request->portal_url;
            $vendor_customer->portal_username   = $request->cust_user_name;
            $vendor_customer->portal_password  = $request->cust_password;
            $vendor_customer->notes  = $request->customer_notes;
           $vendor_customer->save();

            $arr['success'] = 'Customer Added successfully';
            return json_encode($arr);
            exit;
    }

    function editCustomer($id)
    {
          $customer_vendor = VendorCustomer::where('vendor_id', $id)->where('customer_id', Session::get('cust_id'))->first();
          //dd($customer_vendor);
          $vendor = Vendor::find($customer_vendor->vendor_id)->password()->where('customer_id', $customer_vendor->customer_id)->first();
         // dd($vendor);
          $arr['customer'] = $customer_vendor;
          $arr['vendor'] = $vendor;
            return json_encode($arr);
            exit;
    }

    public function updateCustomer(Request $request)
    {
     // dd($request->all());
        $this->validate(
            $request,
            [
                  'customer_id' => 'required',
                  //'customer' => 'required',


               ]
        );

          $vendor_customer = VendorCustomer::where('customer_id', $request->customer_id)->where('vendor_id', $request->vendor_id)->first();
           $vendor_customer->auth_contact_name = $request->auth_contact_name;
           $vendor_customer->vendor_id = $request->vendor_id;
           $vendor_customer->customer_id = $request->customer_id;
          $vendor_customer->phone_number  = $request->cust_phone;
          $vendor_customer->location_id = $request->customer_location_id;
          $vendor_customer->account_number   = $request->account_number;
          $vendor_customer->portal_url   = $request->portal_url;
          //$vendor_customer->portal_username   = $request->cust_user_name;
          //$vendor_customer->portal_password  = $request->cust_password;
          $vendor_customer->notes  = $request->customer_notes;
         $vendor_customer->save();

        /************************** password update*******************/
         $kpass = KnowledgePassword::where('customer_id', $request->customer_id)->where('vendor_id', $request->vendor_id)->first();
        if ($kpass) {
            if ($request->cust_user_name !='' && $request->cust_password!='') {
                $kpass->login = $request->cust_user_name;
                $kpass->password = $request->cust_password;
                $kpass->update();
            } else {
                $kpass->delete();
            }
        } else {
            $tag = Tag::firstOrCreate(['title' => 'vendor']);


            $kpass = new KnowledgePassword();
            $kpass->login = $request->cust_user_name;
            $kpass->password = $request->cust_password;
            $kpass->customer_id = $request->customer_id;
            $kpass->vendor_id = $request->vendor_id;

           //password atttachment with vendor
            $kpass->save();

           //tags attachment with password
            $kpass->tags()->sync([$tag->id]);
        }
           /************************** password update*******************/


            $arr['success'] = 'Customer Updated successfully';
            return json_encode($arr);
            exit;
    }


    function destroyCustomer(Request $request)
    {
        $customer = VendorCustomer::find($request->customer_id);

        $customer->delete();
         $arr['success'] = 'Customer deleted successfully';
            return json_encode($arr);
            exit;
    }

    function unlinkCustomer(Request $request)
    {

        $customer = VendorCustomer::find($request->id);
       //dd( $customer);
        $pass = KnowledgePassword::where('customer_id', $customer->customer_id)->where('vendor_id', $customer->vendor_id)->first();
/*dd($pass);*/
        if ($pass) {
            $pass->delete();
        }

        $customer->delete();
        $arr['success'] = 'Customer unlinked successfully';
        return json_encode($arr);
        exit;
    }

    function refreshContacts($id)
    {

          $vendor = Vendor::with(['contacts'])->where('id', $id)->first();
          $date_format = Config::where('title', 'date_format')->first();

         return view('vendor::show.contact.ajax_refresh_contacts', compact('vendor', 'date_format'))->render();
    }

    function refreshCustomers($id)
    {

          $vendor = Vendor::with(['customers'])->where('id', $id)->first();
          $date_format = Config::where('title', 'date_format')->first();

         return view('vendor::show.customer.ajax_refresh_customers', compact('vendor', 'date_format'))->render();
    }

    function refreshVendorinfo($id)
    {

          $vendor = Vendor::find($id);
          $date_format = Config::where('title', 'date_format')->first();

          $data['vendor_left_info'] = view('vendor::show.info.vendor_top_left_info', compact('vendor', 'date_format'))->render();
          $data['vendor_right_info'] = view('vendor::show.info.vendor_top_right_info', compact('vendor', 'date_format'))->render();
          $data['business_hours'] = html_entity_decode($vendor->business_hours);

         return $data;
    }


    function searchVendorContacts(Request $request)
    {
        if ($request->v_contact) {
            $vendors_contacts = Vendor::with(['contacts'=>function ($query) use ($request) {
                 $query->where('f_name', 'like', '%'.$request->v_contact.'%')->orWhere('l_name', 'like', '%'.$request->v_contact.'%');
            }])->get();
//dd($vendors_contacts);
             $vendors = Vendor::where('name', 'like', '%'.$request->v_contact.'%')->get();

             $contacts = [];
            foreach ($vendors_contacts as $vendor_contacts) {
                foreach ($vendor_contacts->contacts as $vend_contact) {
                    $contacts[] = ['id'=>$vendor_contacts->id,
                                'vend_contact'=>$vend_contact->f_name.' '.$vend_contact->l_name.' ('.$vendor_contacts->name.')'];
                }
            }
            foreach ($vendors as $vendor) {
                   $contacts[] = ['id'=>$vendor->id,
                                'vend_contact'=>$vendor->name];
            }

             echo json_encode([
                "status" => true,
                "error"  => null,
                "data"   => [
                    "vend_contacts"   => $contacts
                    ]
                ]);
        } else {
            echo json_encode([
            "status" => true,
            "error"  => null,
            "data"   => [
                "vend_contacts"   => []
                ]
            ]);
        }
    }

    function addVendorForCustomer()
    {

        $customers_obj = Customer::with(['locations','locations.contacts'])->where('is_active', 1)->get();
         $customers = [];
        if ($customers_obj->count()) {
            foreach ($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                //dd($user->id);
            }
        }

        $current_customer = false;

        $current_customer_locations = [];
        $current_selected_vendors =[];
        if (!empty(Session::get('cust_id'))) {
                $current_customer = Customer::with(['locations','locations.contacts','vendors'])->where('is_active', 1)->where('id', Session::get('cust_id'))->first();

            if ($current_customer == null) {
                dd("Customer is marked inactive, please activate the customer.");
            }

                //$json = '[';
            if ($current_customer->vendors) {
                foreach ($current_customer->vendors as $c_vendor) {
                    //$json.='{id:'.$c_vendor->id.', text:'.$c_vendor->name.'},';
                    $current_selected_vendors[] =['id'=>$c_vendor->id,
                                                    'text'=>$c_vendor->name];
                }
            }

            if ($current_customer->locations) {
                foreach ($current_customer->locations as $c_loc) {
                    //$json.='{id:'.$c_vendor->id.', text:'.$c_vendor->name.'},';
                    $current_customer_locations[$c_loc->id] = $c_loc->location_name;
                }
            }
                //$json = rtrim($json,',');
               //$json .= ']';
              /*  echo '<pre>';
              print_r( $current_selected_vendors);*/

             // $current_selected_vendors = json_encode($current_selected_vendors,true) ;

             $current_selected_vendors = $current_customer->vendors;
             /* echo '<pre>';
              print_r( $current_selected_vendors);
              exit;*/
              //dd( $current_customer_locations );
        }

        $vendor_records = Vendor::all();

         //$vendors = [];
         $not_selected_vendors = [];
        if ($vendor_records->count()) {
            foreach ($vendor_records as $vendor) {
               /*foreach($current_customer->vendors as $c_vendor)
                {
                  if($vendor->id != $c_vendor->id)
                    $not_selected_vendors[] =['id'=>$vendor->id,
                                                    'text'=>$vendor->name];
                }*/
                $vendors[$vendor->id]=$vendor->name;
                //dd($user->id);
            }
        }
        return view('vendor::add_vendor_for_customer', compact('customers', 'vendors', 'current_customer_locations', 'current_selected_vendors'));
    }

    function ajaxVendorsJson(Request $request)
    {
        //dd($request->all());
        $vendors_list = Vendor::where('name', 'like', '%'.$request->q.'%')->get();
        $current_customer = false;
        if (!empty(Session::get('cust_id'))) {
            $current_customer = Customer::with(['locations','locations.contacts','vendors'])->where('is_active', 1)->where('id', Session::get('cust_id'))->first();
        }


        $vendors = [];
        foreach ($vendors_list as $vendor) {
            $vendor_arr['id']=$vendor->id;
            $vendor_arr['text'] = $vendor->name;
            $vendor_arr['disabled']=false;
            if ($current_customer) {
                foreach ($current_customer->vendors as $c_vendor) {
                    if ($c_vendor->id == $vendor->id) {
                        $vendor_arr['disabled']=true;
                        $vendor_arr['text'] = $vendor->name.' <b>(Already attached)</b>';
                    }
                }
            }
            $vendors[] = $vendor_arr;
        }

            return json_encode(["vendors"   => $vendors,
                                //"selected_vendors" => $selected_vendors
                                ]);

        //return ['items'=>json_encode($vendors)];
    }


    public function storeVendorWithCustomerSelected(Request $request)
    {


        //dd($request->all());
            //dd(json_decode($request->cust_arr));
        if ($request->vendor_flag=='add') {
            $this->validate(
                $request,
                [
                'name' => 'required',
                //'customer' => 'required',
                ]
            );
        }

            //$contact_arr =  json_decode($request->contact_arr);
            //$cust_arr   =  json_decode($request->cust_arr);
            $business_hours_arr =  json_decode($request->business_hours);

        if ($request->vendor_flag=='add') {
            $customer = Customer::with(['vendors'])->where('id', $request->customer_selected_id)->first();

            $vendor = new Vendor;
            $vendor->name = $request->name ;
            $vendor->phone_number = $request->phone ;
            $vendor->dailing_instructions = $request->dialing_instructions ;
            $vendor->website = $request->website;
            $vendor->zip = $request->zip ;
            $vendor->address = $request->address ;
            $vendor->city = $request->city ;
            $vendor->state = $request->state ;
            $vendor->business_hours = $request->business_hours ;

            $vendor->save();


            //$vendor_ids = explode(',', $request->vendor_id);
            $vendor_customer = [];
            $vendor_customer['auth_contact_name']= $request->auth_contact_name;
            $vendor_customer['phone_number'] = $request->cust_phone;
            $vendor_customer['location_id'] = $request->customer_location_id;
            $vendor_customer['account_number']  = $request->account_number;
            $vendor_customer['portal_url']  = $request->portal_url;
            //$vendor_customer['portal_username']  = $request->cust_user_name;
            //$vendor_customer['portal_password'] = $request->cust_password;
            $vendor_customer['notes'] = $request->customer_notes;


         /********************tag attachment**************************/
            $tag = Tag::firstOrCreate(['title' => 'vendor']);


            $kpass = new KnowledgePassword();
            $kpass->login = $request->cust_user_name;
            $kpass->password = $request->cust_password;
            $kpass->customer_id = $request->customer_selected_id;

            //password atttachment with vendor
            $pass = $vendor->password()->save($kpass);

            //tags attachment with password
            $pass->tags()->attach([$tag->id]);

            /****************************************************/



            $customer->vendors()->attach($vendor->id, $vendor_customer);
        }

        if ($request->vendor_flag=='attach') {
            $customer = Customer::with(['vendors'])->where('id', $request->customer_selected_id)->first();
            //$customer->vendors()->detach();



            //$vendor_ids = explode(',', $request->vendor_id);
            $vendor_customer = [];
            $vendor_customer['auth_contact_name']= $request->auth_contact_name;
            $vendor_customer['phone_number'] = $request->cust_phone;
            $vendor_customer['account_number']  = $request->account_number;
            $vendor_customer['location_id'] = $request->customer_location_id;
            $vendor_customer['portal_url']  = $request->portal_url;
            //$vendor_customer['portal_username']  = $request->cust_user_name;
            //$vendor_customer['portal_password'] = $request->cust_password;
            $vendor_customer['notes'] = $request->customer_notes;

            /********************tag attachment**************************/
            $tag = Tag::firstOrCreate(['title' => 'vendor']);

            $vendor = Vendor::find($request->vendor_id);

            $kpass = new KnowledgePassword();
            $kpass->login = $request->cust_user_name;
            $kpass->password = $request->cust_password;
            $kpass->customer_id = $request->customer_selected_id;

            //password atttachment with vendor
            $pass = $vendor->password()->save($kpass);

            //tags attachment with password
            $pass->tags()->attach([$tag->id]);

            /****************************************************/
            /*$each_cust_arr=[];
            foreach ($vendor_ids as  $vendor) {

              $each_cust_arr[$vendor] = $vendor_customer;
            }*/
            $customer->vendors()->attach($request->vendor_id, $vendor_customer);
        }


           $arr['success'] = 'Vendor(s) attached successfully';
            return json_encode($arr);
            exit;
        //
    }



    function custsNotAttachedToVendor($v_id)
    {

         $customers = Customer::where('is_active', 1)->get();

         $vendors = VendorCustomer::where('vendor_id', $v_id)->get();

         $unattached_customers = [];
        foreach ($customers as $customer) {
            $cust_arr['id'] = $customer->id;
            $cust_arr['name'] = $customer->name;
            $cust_arr['disabled'] = false;

            foreach ($vendors as $vendor) {
                if ($vendor->customer_id == $customer->id) {
                     $cust_arr['name'] = $customer->name.'(Already Selected)';
                    $cust_arr['disabled'] = true;
                }
            }

            $unattached_customers[]= $cust_arr;
        }
        // dd($unattached_customers);
         return json_encode(['customers'=>$unattached_customers]);
    }
}
