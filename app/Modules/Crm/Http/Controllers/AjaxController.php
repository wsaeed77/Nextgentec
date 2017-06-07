<?php
namespace App\Modules\Crm\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Modules\Crm\Http\TicketStatus;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Crm\Http\CustomerNote;
use App\Modules\Crm\Http\CustomerLocationContact;
use App\Modules\Crm\Http\CustomerServiceItem;
use App\Model\Role;
use App\Model\User;

use App\Model\Config;
use Auth;
use Datatables;
use Mail;

class AjaxController extends Controller
{
    // Select2 Get Ticket Statuses List
    function getSelect2Statuses()
    {
        $statuses_ = TicketStatus::select('title as text', 'id');
        return json_encode($statuses_->get());
        exit;
    }

    // Select2 Get Customer Locations List
    function getSelect2Locations($cust_id)
    {
        $data = CustomerLocation::where('customer_id', $cust_id)->select('id', 'location_name as text')->get();
        return json_encode($data);
        exit;
    }

    // Select2 Get Customer Contacts List
    function getSelect2Contacts($cust_id)
    {
        $contacts = CustomerLocationContact::
        leftJoin('customer_locations', 'customer_location_contacts.customer_location_id', '=', 'customer_locations.id')
           ->select(DB::raw('CONCAT(f_name, " ", l_name) AS text'), 'customer_location_contacts.id as id')
           ->where('customer_id', $cust_id);

        return json_encode($contacts->get());
        exit;
    }

    // Select2 Get Technicians List
    function getSelect2Techs()
    {
        $techs = Role::
        rightJoin('role_user', 'role_user.role_id', '=', 'roles.id')
        ->rightJoin('users', 'role_user.user_id', '=', 'users.id')
        ->select(DB::raw('CONCAT(f_name, " ", l_name) AS text'), 'users.id as id');

        return json_encode($techs->get());
        exit;
    }

    // Select2 Get Service Items List
    function getSelect2ServiceItems($cust_id)
    {
        $contacts = CustomerServiceItem::
        select('title as text', 'id')
           ->where('customer_id', $cust_id);

        return json_encode($contacts->get());
        exit;
    }

    // Get Customer Notes in JSON
    function getCustomerNotes($cust_id)
    {
        $notes = CustomerNote::where('customer_id', $cust_id)->get();

        foreach ($notes as &$note) {
            $string = preg_replace("/[\r\n]{2,}/", " ", strip_tags($note['note']));
            $note['note'] = $this->shortenString(rtrim($string), 15);
        }

        return json_encode($notes);
        exit;
    }

    private function shortenString($sentence, $count = 10)
    {
        preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
        return $matches[0];
    }

    // Create Customer Note in JSON
    function createCustomerNote(Request $request)
    {
        $this->validate($request, [
        'customer_id' => 'required',
        'subject' => 'required',
        'note' => 'required'
        ]);
      //dd($request->all());

        $note_obj = new CustomerNote;
        $note_obj->customer_id = $request->customer_id;
        $note_obj->subject = $request->subject;
        $note_obj->source = $request->source;
        $note_obj->note = $request->note;
        $note_obj->archived = 0;
        $note_obj->created_by = Auth::user()->id;

        if ($note_obj->save()) {
            $arr['success'] = 'Note added successfully';
            return json_encode($arr);
        }
        exit;
    }

    function updateCustomer(Request $request)
    {
        dd($request->all());
        $customer = Customer::findOrFail($request->pk);

        $name = $request->get('name');
        $value = $request->get('value');
        if (is_array($value)) {
            $value = $value[0];
        }
        $customer->{$name} = $value;
        $customer->save();

        $arr['success'] = 'Customer info updated successfully';
        return json_encode($arr);
        exit;
    }


    function sendEmails(Request $request)
    {
       //dd($request->all());


       
        $smtp_arr = Config::where('title', 'smtp')->get();

          $smtp =[];
        foreach ($smtp_arr as $value) {
            if ($value->key=='server_address') {
                $server_address = $value->value;
            }
            if ($value->key=='gmail_address') {
                $gmail_address = $value->value;
            }
            if ($value->key=='gmail_password') {
                $password = $value->value;
            }
            if ($value->key=='port') {
                $port= $value->value;
            }
        }


            config(['mail.driver' => 'smtp',
                  'mail.host' => $server_address,
                  'mail.port' => $port,
                  'mail.encryption' => 'ssl',
                  'mail.username' => $gmail_address,
                  'mail.password' => $password,
                  'mail.from' =>['address'=>$gmail_address,'name'=>'Nexgentec']]);

            $cc = $request->cc;
            $to = $request->to;

            $body  = $request->email_body;
            //$body .= $email_signature;


          Mail::send('crm::ticket.email.response', ['body'=>$body], function ($message) use ($request, $gmail_address, $to, $cc) {

                  
                  
            if (count($cc)>0) {
                foreach ($cc as $key => $cc_email) {
                    $message->cc(trim($cc_email), $name = null);
                }
            }


                   //$headers->addTextHeader('References', $ticket->gmail_msg_id);
                    $message->from(trim($gmail_address), Auth::user()->f_name.' '.Auth::user()->l_name);
            if (count($to)>0) {
                foreach ($to as $key => $to_email) {
                          //$message->cc(trim($to_email), $name = null);
                    $message->to(trim($to_email), $name = null);
                }
            }
                   //$message->to(trim($ticket->email),$ticket->sender_name);
                    $message->subject($request->email_subject);
          });

          return json_encode(['success'=>'yes']);
          exit;
    }

    function displayDataHtable()
    {



        return view('crm::notes.handsontable');
    }
}
