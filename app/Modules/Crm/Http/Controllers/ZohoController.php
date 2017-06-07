<?php
namespace App\Modules\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerServiceType;
use App\Modules\Crm\Http\CustomerBillingPeriod;
use App\Modules\Crm\Http\CustomerServiceItem;
use App\Modules\Crm\Http\CustomerServiceRate;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Crm\Http\Invoice;
use App\Modules\Crm\Http\CustomerLocationContact;
use App\Modules\Crm\Http\Zoho;
use App\Model\Role;
use App\Model\User;
use Auth;
use App\Model\Config;
use Session;

class ZohoController extends Controller
{
    private $customer;

    private $zoho_contacts;

    //public $zoho_unimported_contacts=[];


    
    public function import()
    {
        $route_delete = 'admin.crm.destroy';
        return view('crm::crm.import', compact('route_delete'));
    }

    function ajaxExportContact($id)
    {
         $customer_data = Customer::with(['locations','locations.contacts'])->where('id', $id)->first();

       //dd($customer_data->locations);

         $contacts = [];


         $billing_address = [];
        foreach ($customer_data->locations as $location) {
            if ($location->default) {
                $billing_address = [
                 "address" => $location->address,
                 "city" => $location->city,
                 "state" => $location->state,
                 "zip" => $location->zip,
                 "country" => $location->country];
            }

            foreach ($location->contacts as $contact) {
                $contacts[] = [
                      "first_name"=>$contact->f_name,
                      "last_name"=>$contact->l_name,
                      "email"=>$contact->email,
                      "phone"=>$contact->phone,
                      "mobile"=>$contact->mobile,
                      "is_primary_contact"=>($contact->is_poc)?true:''];
            }
        }
            //$zoho = Zoho::first();
            $zoho_auth_token =  Config::where('key', 'auth_token')->where('title', 'zoho')->first();

                $ch = curl_init();

                $post["contact_name"]= $customer_data->name;
                $post["company_name"]= $customer_data->email_domain;


                $post['contact_persons'] = $contacts;
                $post['billing_address'] = $billing_address;

                $data = array(
                'authtoken' => $zoho_auth_token->value,
                'JSONString' => json_encode($post)

                );

                $url = 'https://invoice.zoho.com/api/v3/contacts';

                $curl = curl_init($url);

                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


                $result_curl = curl_exec($curl);
                $result = json_decode($result_curl);


        if ($result->code==0) {
            $customer_to_update = Customer::find($id);
            $customer_to_update->zohoid =  $result->contact->contact_id;
            $customer_to_update->save();
            // $customer_to_update->zohoid =

            $arr['success'] = 'Exported customer to Zoho invoice successfully.';
        } else {
            $arr['error'] = 'Error occured.' ;
            $arr['error_msg'] = $result->message;
        }
        return json_encode($arr);
    }


    function getForm()
    {
      //$zoho = Config::where('title','zoho')->get();
        $zoho = Config::where('title', 'zoho')->get();

        foreach ($zoho as $value) {
            if ($value->key=='email') {
                $zoho_arr['email'] = $value->value;
            }
            if ($value->key=='password') {
                $zoho_arr['password'] = $value->value;
            }
            if ($value->key=='auth_token') {
                $zoho_arr['auth_token'] = $value->value;
            }
        }


         return view('crm::zoho.add', compact('zoho_arr'))->render();
    }

   

    function getZohoContacts()
    {
        $zoho_auth_token =  Config::where('key', 'auth_token')->where('title', 'zoho')->first();
        $data = array(
        'authtoken' => $zoho_auth_token->value
        );

        $url = 'https://invoice.zoho.com/api/v3/contacts?authtoken='.$zoho_auth_token->value;
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result_curl = curl_exec($curl);
        $result = json_decode($result_curl);


     // dd($result);
      //return $result;
        $this->zoho_contacts = $result->contacts;
        $zoho_unimported_contacts =[];
        foreach ($this->zoho_contacts as $contact) {
            if (!Customer::where('zohoid', $contact->contact_id)->first()) {
                $zoho_unimported_contacts[] = $contact;
              //$url = 'https://invoice.zoho.com/api/v3/contacts/'.$contact->contact_id.'?authtoken='.$zoho->auth_token;
             // dd($this->zoho_unimported_contacts);
            }
        }
       
        //dd($zoho_unimported_contacts);

        //$return['view'] = view('crm::zoho.unimported_contacts_partial',compact('zoho_unimported_contacts'))->render();
        Session::put('unimported_zoho_contacts', $zoho_unimported_contacts);
        $return['success']= 'ok';
        return json_encode($return);
      //dd($result);

      // $contacts =[];
      // foreach($result->contacts as $contact) {
      //
      // }
    }

    function listZohoUnimportedContacts()
    {
      //dd(Session::get('unimported_zoho_contacts'));


        $zoho_unimported_contacts = Session::get('unimported_zoho_contacts');

        

        return view('crm::zoho.unimported_list', compact('zoho_unimported_contacts'));
    }

    function importSelectedContacts(Request $request)
    {
        $zoho_auth_token =  Config::where('key', 'auth_token')->where('title', 'zoho')->first();
        $data = array(
        'authtoken' => $zoho_auth_token->value
        );

        $zoho_unimported_contacts = Session::get('unimported_zoho_contacts');



        $selected_ids = explode(',', $request->selected_id);
     // dd($selected_ids);
        foreach ($zoho_unimported_contacts as $contact_) {
            if (in_array($contact_->contact_id, $selected_ids)) {
                $url = 'https://invoice.zoho.com/api/v3/contacts/'.$contact_->contact_id.'?authtoken='.$zoho_auth_token->value;

                $curl_detail = curl_init($url);

                curl_setopt($curl_detail, CURLOPT_RETURNTRANSFER, 1);


                $result_curl_detail = curl_exec($curl_detail);
                $contact_r = json_decode($result_curl_detail);
                $contact = $contact_r->contact;
/*echo '<pre>';
print_r($contact);*/
//dd($contact);
                $customer = new Customer;
                $customer->name  = $contact->contact_name;
           // $customer->main_phone = $contact->phone;
                $customer->email_domain = $contact->company_name;
                $customer->customer_since = date("Y-m-d", strtotime($contact->created_time));
                $customer->zohoid =  $contact->contact_id;
                $customer->is_active = ($contact->status=='active')? 1 : 0;
            //$customer->is_taxable = $contact->taxable;
                $customer->created_at = date('Y-m-d', strtotime($contact->created_time));
                $customer->updated_at =  date('Y-m-d', strtotime($contact->last_modified_time));
                $customer->save();

                $billing_address = $contact->billing_address;
                $shipping_address = $contact->shipping_address;
                if ($billing_address->city!='') {
                    $location_obj = new CustomerLocation;
                       $location_obj->location_name = $billing_address->city;
                       $location_obj->address = $billing_address->address;
                       $location_obj->country = $billing_address->country;
                       $location_obj->city = $billing_address->city;
                       $location_obj->zip = $billing_address->zip;
                       $location_obj->phone = $billing_address->fax;
                    $location_obj->customer_id = $customer->id;
                    $location_obj->default =1;
                    $location_obj->save();
                }

                if ($shipping_address->city!='') {
                    $location_obj = new CustomerLocation;
                       $location_obj->location_name = $shipping_address->city;
                       $location_obj->address = $shipping_address->address;
                       $location_obj->country = $shipping_address->country;
                       $location_obj->city = $shipping_address->city;
                       $location_obj->zip = $shipping_address->zip;
                       $location_obj->phone = $shipping_address->fax;
                    $location_obj->customer_id = $customer->id;
                    $location_obj->default =0;
                    $location_obj->save();
                }
                if ($shipping_address->city=='' && $billing_address->city=='') {
                    $location_obj = new CustomerLocation;
                    $location_obj->location_name = 'location';

                    $location_obj->customer_id = $customer->id;
                    $location_obj->default =0;
                    $location_obj->save();
                }
                foreach ($contact->contact_persons as $contact_) {
                    $contact_obj         = new CustomerLocationContact;
                    $contact_obj->f_name = $contact_->first_name;
                    $contact_obj->l_name = $contact_->last_name;
                    $contact_obj->email  = $contact_->email;
                    //$contact_obj->title  = $contact->title_;
                    $phone = explode('-', $contact_->phone);
                    $contact_obj->phone = '('. $phone[1].')'.' '.$phone[2].'-'.$phone[3];
                    //$contact_obj->phone  = $contact_->phone;
                    $contact_obj->mobile = $contact_->mobile;
                    $contact_obj->is_poc = $contact_->is_primary_contact?1:0;
                    $contact_obj->customer_location_id = $location_obj->id;

                       $contact_obj->save();
                }
            }
        }
             $arr['success'] = 'Imported customers from Zoho invoice successfully.Page will be refreshed in a while.';
        return json_encode($arr);
        exit;
    }

    function getContacts()
    {
        //$zoho = Zoho::first();
        $zoho_auth_token =  Config::where('key', 'auth_token')->where('title', 'zoho')->first();
        $data = array(
                'authtoken' => $zoho_auth_token->value

                );

            $url = 'https://invoice.zoho.com/api/v3/contacts?authtoken='.$zoho_auth_token->value;

            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


            $result_curl = curl_exec($curl);
            $result = json_decode($result_curl);

           // dd($result);
                $contacts =[];
        foreach ($result->contacts as $contact_) {
            if (!Customer::where('zohoid', $contact_->contact_id)->first()) {
                $url = 'https://invoice.zoho.com/api/v3/contacts/'.$contact_->contact_id.'?authtoken='.$zoho->auth_token;

                $curl_detail = curl_init($url);

                curl_setopt($curl_detail, CURLOPT_RETURNTRANSFER, 1);


                $result_curl_detail = curl_exec($curl_detail);
                $contact = json_decode($result_curl_detail);

                $customer = new Customer;
                $customer->name  = $contact->contact_name;
           // $customer->main_phone = $contact->phone;
                $customer->email_domain = $contact->company_name;
                $customer->customer_since = date("Y-m-d", strtotime($contact->created_time));
                $customer->zohoid =  $contact->contact_id;
                $customer->is_active = ($contact->status=='active')? 1 : 0;
            //$customer->is_taxable = $contact->taxable;
                $customer->created_at = date('Y-m-d', strtotime($contact->created_time));
                $customer->updated_at =  date('Y-m-d', strtotime($contact->last_modified_time));
                $customer->save();

                $billing_address = $contact->billing_address;
                $shipping_address = $contact->shipping_address;
                if ($billing_address->city!='') {
                    $location_obj = new CustomerLocation;
                       $location_obj->location_name = $billing_address->city;
                       $location_obj->address = $billing_address->address;
                       $location_obj->country = $billing_address->country;
                       $location_obj->city = $billing_address->city;
                       $location_obj->zip = $billing_address->zip;
                       $location_obj->phone = $billing_address->fax;
                    $location_obj->customer_id = $customer->id;
                    $location_obj->default =1;
                    $location_obj->save();
                }

                if ($shipping_address->city!='') {
                    $location_obj = new CustomerLocation;
                       $location_obj->location_name = $shipping_address->city;
                       $location_obj->address = $shipping_address->address;
                       $location_obj->country = $shipping_address->country;
                       $location_obj->city = $shipping_address->city;
                       $location_obj->zip = $shipping_address->zip;
                       $location_obj->phone = $shipping_address->fax;
                    $location_obj->customer_id = $customer->id;
                    $location_obj->default =0;
                    $location_obj->save();
                }
                if ($shipping_address->city=='' && $billing_address->city=='') {
                    $location_obj = new CustomerLocation;
                    $location_obj->location_name = 'location';

                    $location_obj->customer_id = $customer->id;
                    $location_obj->default =0;
                    $location_obj->save();
                }
                foreach ($contact->contact_persons as $contact_) {
                    $contact_obj         = new CustomerLocationContact;
                    $contact_obj->f_name = $contact_->first_name;
                    $contact_obj->l_name = $contact_->last_name;
                    $contact_obj->email  = $contact_->email;
                    //$contact_obj->title  = $contact->title_;
                    $phone = explode('-', $contact_->phone);
                    $contact_obj->phone = '('. $phone[1].')'.' '.$phone[2].'-'.$phone[3];
                    //$contact_obj->phone  = $contact_->phone;
                    $contact_obj->mobile = $contact_->mobile;
                    $contact_obj->is_poc = $contact_->is_primary_contact?1:0;
                    $contact_obj->customer_location_id = $location_obj->id;

                       $contact_obj->save();
                }
            }
        }
             $arr['success'] = 'Imported customers from Zoho invoice successfully.Page will be refreshed in a while.';
        return json_encode($arr);
        exit;
            exit;
    }

    function getExpense($cust_id)
    {
        //$zoho =  Zoho::first();
        $zoho_auth_token =  Config::where('key', 'auth_token')->where('title', 'zoho')->first();
        $url = 'https://invoice.zoho.com/api/v3/expenses?authtoken='.$zoho_auth_token->value.'&customer_id='.$cust_id;

        $curl = curl_init($url);
       // curl_setopt($curl, CURLOPT_POST, true);
        //curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


        $result_curl = curl_exec($curl);
        $result = json_decode($result_curl);

        $expense_dates = [];
        foreach ($result->expenses as $expense) {
            $expense_dates[] = $expense->date;
        }


        dd($result);
    }

    private function zohocurl($path, $params)
    {
      //$zoho = Zoho::first();
        $zoho_auth_token =  Config::where('key', 'auth_token')->where('title', 'zoho')->first();
        $url = 'https://invoice.zoho.com/api/v3/'.$path.'?authtoken='.trim($zoho_auth_token->value);
        foreach ($params as $paramkey => $paramvalue) {
            $url .= '&'.$paramkey.'='.$paramvalue;
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        return json_decode(curl_exec($curl));
    }

    /**
     * Zoho List all invoices
     *
     * @param  int    $cust_id Id of the customer to lookup
     * @param  string $status  Search invoices by invoice status.
     *                         Allowed Values: sent, draft, overdue, paid,
     *                         void, unpaid, partially_paid and viewed
     * @return json            Invoices
     */
    private function getInvoices($cust_id, $status)
    {
        $this->customer = Customer::with('invoices')->where('id', $cust_id)->first();

        $curlParams = array(
        'customer_id' => $this->customer['zohoid'],
        'status' => $status
        );

        return $this->zohocurl('invoices', $curlParams)->invoices;
    }

    /**
     * Zoho List all recurring invoices
     *
     * @param  int    $cust_id Id of the customer to lookup
     * @param  string $status  Search invoices by invoice status.
     *                         Allowed Values: active, stopped and expired
     * @return json            Invoices
     */
    private function getRecurringInvoices($cust_id, $status)
    {
        $customer = Customer::with('invoices')->where('id', $cust_id)->first();
        return $this->zohocurl('recurringinvoices', array('customer_id' => $customer['zohoid']));
    }

    /**
     * Zoho Get Invoice
     *
     * @param  int    $zoho_id Id of the invoice
     * @return json            Invoice
     */
    private function getInvoice($zoho_id)
    {
        return $this->zohocurl('invoices/'.$zoho_id, array('accept' => 'json'));
    }

    function importInvoices($cust_id)
    {
        $customer = Customer::with('invoices')->where('id', $cust_id)->first();

        $curlData = $this->zohocurl('invoices', array('customer_id' => $customer['zohoid'], 'per_page' => '100'));

        $continue = true;
        $page = 2;
        $qty = 0;
      // Handle first page and any more pages
        while ($continue) {
            foreach ($curlData->invoices as $invoice) {
                $invoice_obj = Invoice::firstOrNew(['zohoid' => $invoice->invoice_id]);
                $invoice_obj->zohoid = $invoice->invoice_id;
                $invoice_obj->status = $invoice->status;
                $invoice_obj->invoice_number = $invoice->invoice_number;
                $invoice_obj->reference_number = $invoice->reference_number;
                $invoice_obj->date = $invoice->date;
                $invoice_obj->due_date = $invoice->due_date;
                $invoice_obj->due_days = $invoice->due_days;
                $invoice_obj->currency_code = $invoice->currency_code;
                $invoice_obj->total = $invoice->total;
                $invoice_obj->balance = $invoice->balance;
                $invoice_obj->created_time = $invoice->created_time;
                $invoice_obj->last_modified_time = $invoice->last_modified_time;
                $invoice_obj->is_emailed = $invoice->is_emailed;
                $invoice_obj->reminders_sent = $invoice->reminders_sent;
                $invoice_obj->last_reminder_sent_date = $invoice->last_reminder_sent_date;
                $invoice_obj->payment_expected_date = $invoice->payment_expected_date;
                $invoice_obj->last_payment_date = $invoice->last_payment_date;
                $invoice_obj->customer_id = $cust_id;
                $invoice_obj->save();
                $qty++;
            }
            $continue = $curlData->page_context->has_more_page;
            $curlData = $this->zohocurl('invoices', array('customer_id' => $customer['zohoid'], 'per_page' => '100', 'page' => $page));
        }
        $result = array(
        'success' => 'Invoices imported',
        'quantity' => $qty
        );
        return json_encode($result);
    }

    /**
     * API v1 Zoho List all invoices
     */
    function apiGetInvoices($cust_id, $status = null)
    {
        $invoices = $this->getInvoices($cust_id, $status);

        $return = array();
        $i=0;
        foreach ($invoices as $invoice) {
            if ($status == 'unpaid' && $invoice->status != 'paid') {
                $return[$i]['invoice_number'] = $invoice->invoice_number;
                $return[$i]['due_days'] = $invoice->due_days;
                $return[$i]['status'] = $invoice->status;
                $return[$i]['balance'] = '$' . number_format($invoice->balance, 2);
                $return[$i]['total'] = '$' . number_format($invoice->total, 2);
                $return[$i]['zohoId'] = $invoice->invoice_id;

                // Get the invoice URL for printing
                $invoice = $this->getInvoice($invoice->invoice_id);
                $return[$i]['url'] = $invoice->invoice->invoice_url;

                $i++;
            }
        }
        return json_encode($return);
    }

    /**
     * API v1 Zoho List all recurring invoices
     */
    function apiGetRecurringInvoices($cust_id, $status = 'active')
    {
        $result = $this->getRecurringInvoices($cust_id, $status);
        $recInv = $result->recurring_invoices;

        $return = array();
        $i=0;
        foreach ($recInv as $invoice) {
            $return[$i]['totalAmt'] = '$' . number_format($invoice->total, 2);
            $return[$i]['name'] = $invoice->recurrence_name;
            $return[$i]['status'] = $invoice->status;
            $return[$i]['zohoId'] = $invoice->recurring_invoice_id;
            $return[$i]['autoBill'] = $invoice->is_autobill_enabled;
            $i++;
        }
        return json_encode($return);
    }

    function apiGetCustomerStanding($cust_id)
    {
        $unpaid_invoices = $this->getInvoices($cust_id, 'unpaid');

        $result = array(
        'credit_limit_standing' => null,
        'credit_limit_used' => null,
        'qty_overdue' => 0,
        'qty_waiting' => 0,
        'amt_overdue' => 0,
        'amt_waiting' => 0,
        'waiting' => array(),
        'overdue' => array()
        );
        foreach ($unpaid_invoices as $invoice) {
            if ($invoice->status == 'overdue') {
                $overdue = array(
                'invoice_number' => $invoice->invoice_number,
                'due_days' => $invoice->due_days
                );
                array_push($result['overdue'], $overdue);
                $result['qty_overdue']++;
                $result['amt_overdue'] += $invoice->balance;
            }
            if ($invoice->status == 'sent') {
                $waiting = array(
                'invoice_number' => $invoice->invoice_number,
                'due_days' => $invoice->due_days
                );
                array_push($result['waiting'], $waiting);
                $result['qty_waiting']++;
                $result['amt_waiting'] += $invoice->balance;
            }
        }

        if ($this->customer->credit_limit != 0) {
            $result['credit_limit_standing'] = 'good';
            $amt_unpaid = $result['amt_overdue'] + $result['amt_waiting'];
            $result['credit_limit_used'] = number_format($amt_unpaid / $this->customer->credit_limit * 100, 0) . '%';

            if (($amt_unpaid / $this->customer->credit_limit) >= .75) {
                $result['credit_limit_standing'] = 'warning';
            }
            if (($amt_unpaid / $this->customer->credit_limit) >= 1) {
                $result['credit_limit_standing'] = 'overlimit';
            }
        }

        return json_encode($result);
    }
}
