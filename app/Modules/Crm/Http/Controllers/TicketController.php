<?php
namespace App\Modules\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\Employee;

use App\Modules\Crm\Http\Ticket;
use App\Modules\Crm\Http\GmailEmailLog;
use App\Modules\Crm\Http\TicketStatus;



use App\Modules\Crm\Http\Attachment;

use App\Modules\Crm\Http\Response;


use App\Services\GoogleGmail;
use App\Services\ImapGmail;

use App\Modules\Crm\Http\CustomerServiceType;
use App\Modules\Crm\Http\CustomerBillingPeriod;
use App\Modules\Crm\Http\CustomerServiceItem;
use App\Modules\Crm\Http\CustomerServiceRate;
use App\Modules\Crm\Http\CustomerLocation;



use App\Modules\Crm\Http\CustomerLocationContact;

use App\Model\Config;

use App\Model\Role;
use App\Model\User;
use Auth;
use Mail;
use URL;
use Session;

use Datatables;
use SlackApi;
use SlackChat;

class TicketController extends Controller
{

    public function index(Request $request)
    {

        //dd($id);
        if (!empty(Session::get('cust_id'))) {
            $tickets_qry = Ticket::with(['responses','entered_by','customer','location','service_item','status','customer_contact'])->where('customer_id', Session::get('cust_id'));
        } else {
            $tickets_qry = Ticket::with(['responses','entered_by','customer','location','service_item','status','customer_contact']);
        }

        if ($request->filter=='clear') {
            Session::forget('arr_input');
        }

        $paginate = 5;
        if ($request->filter == 'yes' || (Session::has('arr_input') && count(Session::get('arr_input'))>0)) {
            if ($request->filter=='yes') {
                Session::put('arr_input', $request->all());
            }


            if (!empty(Session::get('arr_input.customer'))) {
                $tickets_qry->where('customer_id', '=', Session::get('arr_input.customer'));
            }

            if (!empty(Session::get('arr_input.per_page'))) {
                $paginate = Session::get('arr_input.per_page');
            }


            if (Session::has('arr_input.sort')) {
                if (Session::get('arr_input.sort')=='created_at_asc') {
                    $tickets_qry->orderBy('tickets.created_at', 'asc');
                }

                if (Session::get('arr_input.sort')=='updated_at') {
                    $tickets_qry->orderBy('tickets.updated_at', 'desc');
                }

                if (Session::get('arr_input.sort') =='created_at_desc') {
                    $tickets_qry->orderBy('tickets.created_at', 'desc');
                }

                if (Session::has('arr_input.sort')=='priority') {
                    $tickets_qry->orderBy('tickets.priority', 'asc');
                }
            }

            if (Session::has('arr_input.priority') && count(Session::get('arr_input.priority'))>0) {
                foreach (Session::get('arr_input.priority') as $priority => $on) {
                    $tickets_qry->orWhere('tickets.priority', $priority);
                    //echo $priority.'<br/>';
                }
            }
            if (!empty(Session::get('arr_input.assigned_to'))) {
                $tickets_qry->whereHas('assigned_to', function ($query) {
                    $query->where('user_id', Session::get('arr_input.assigned_to'));
                });
            }
        } else {
            $tickets_qry->orderBy('tickets.created_at', 'desc');
        }

        $tickets = $tickets_qry->paginate($paginate);


        $customers_obj = Customer::with(['locations','locations.contacts'])->get();
        $customers = [];
        if ($customers_obj->count()) {
            foreach ($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                //dd($user->id);
            }
        }

        $users_obj =  Role::with('users')->where('name', 'manager')->orWhere('name', 'technician')->get();
        $users=[];
        if ($users_obj->count()) {
            foreach ($users_obj as $user_obj) {
                foreach ($user_obj->users as $user) {
                    $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$user_obj->name.')';
                        //dd($user->id);
                }
            }
        }

        $statuses_ = TicketStatus::all();
        $statuses = [];
        if ($statuses_->count()) {
            foreach ($statuses_ as $status) {
                $statuses[$status->id]=$status->title;
                //dd($user->id);
            }
        }

        return view('crm::ticket.index.index', compact('tickets', 'customers', 'users', 'statuses'));
    }



    public function ajaxDataIndex($id = null)
    {
        //$controller = $this->controller;
        $global_date = $this->global_date;

        if ($id!='') {
            $tickets = Ticket::with(['responses','assigned_to','entered_by','customer','location','service_item','status'])->where('customer_id', $id);
        } else {
            $tickets = Ticket::with(['responses','assigned_to','entered_by','customer','location','service_item','status']);
        }


        return Datatables::of($tickets)



        ->addColumn('created_by', function ($ticket) {
            if ($ticket->entered_by) {
                $return = $ticket->entered_by->f_name;
            } elseif ($ticket->type =='email') {
                $return = '<button type="button" class="btn bg-gray-active  btn-sm">

        <span>system</span>
    </button>';
            }


            return $return;
        })
        ->addColumn('customer_info', function ($ticket) {
            $return = '<button type="button" class="btn bg-gray-active  btn-sm">

        <span>';

            if ($ticket->customer) {
                $return .=  '<i class="fa fa-user"></i>'. $ticket->customer->name;
            } elseif ($ticket->email) {
                $return .= '<i class="fa fa-envelope"></i>'.$ticket->email;
            }

             $return .='</span></button>';
            if ($ticket->location) {
                $return .= ' <button type="button" class="btn bg-gray-active  btn-sm">
         <i class="fa fa-map-marker"></i>
         <span>'.$ticket->location->location_name.'</span>
     </button>';
            }
            if ($ticket->service_item) {
                $return .= ' <button type="button" class="btn bg-gray-active  btn-sm">
    <i class="fa  fa-gears"></i>
    <span>'.$ticket->service_item->title.'</span>
</button>';
            }


            return $return;
        })
        ->addColumn('assigned_to', function ($ticket) {

             //$customer->locations //loop
            $return = '';
            if ($ticket->assigned) {
                foreach ($ticket->assigned_to as $employee) {
                    $return .= '<button type="button" class="btn bg-gray-active  btn-sm">

           <i class="fa fa-user"></i>
           <span>'.$employee->f_name.'</span>
       </button>';
                }
            }
            return $return;
        })
        ->editColumn('created_at', function ($ticket) use ($global_date) {

            return  date($global_date, strtotime($ticket->created_at));
        })
        ->editColumn('priority', function ($ticket) {
            $btn_class = 'bg-gray';
            if ($ticket->priority == 'normal') {
                $btn_class = 'bg-blue';
            }
            if ($ticket->priority == 'high') {
                $btn_class = 'bg-green';
            }
            if ($ticket->priority == 'urgent') {
                $btn_class = 'bg-yellow';
            }
            if ($ticket->priority == 'critical') {
                $btn_class = 'bg-red';
            }
            $return = '<button type="button" class="btn '.$btn_class.'  btn-sm">
    <span>'.$ticket->priority.'</span>
</button>';

            return $return;
        })
        ->editColumn('status', function ($ticket) {
            $return ='<button type="button" class="btn   btn-sm" style="background-color:'.$ticket->status->color_code.'">
        <span>'.$ticket->status->title.'</span>
    </button>';

            return $return;
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

        $customers_obj = Customer::with(['locations','locations.contacts'])->get();
        $customers = [];
        if ($customers_obj->count()) {
            foreach ($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                //dd($user->id);
            }
        }

        $managers_obj =  Role::with('users')->where('name', 'manager')->orWhere('name', 'technician')->get();


        $users = [];
        $roles = [];

        if ($managers_obj->count()) {
            foreach ($managers_obj as $manager_obj) {
                foreach ($manager_obj->users as $user) {
                    $users[$user->id]=$user->f_name." ".$user->l_name.'('.$manager_obj->name.')';
                //dd($user->id);
                }
            }
        }


        $statuses_ = TicketStatus::all();
        $statuses = [];
        if ($statuses_->count()) {
            foreach ($statuses_ as $status) {
                $statuses[$status->id]=$status->title;
                //dd($user->id);
            }
        }



        return view('crm::ticket.add', compact('users', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $slack_channel =  Config::where('key', 'channel')->where('title', 'slack')->first();

        $slack_access_token =  Config::where('key', 'access_token')->where('title', 'slack')->first();

        config(['services.slack.token' => $slack_access_token->value]);

        //customer contact is text field but with magic suggest it adds an array, throwing exception upon validation, so modifyig it, i.e assigning the aaray value to customer_contact
        $request->merge(['customer_contact' => $request->customer_contact[0]]);
        //saving customer_contact value in session to display upon validation in blade.
        $request->session()->put('cust_cont', $request->customer_contact);

        $validator = \Validator::make(\Input::all(), [
            'customer_contact' => 'required',
            'title'=>'required',
            'body'=>'required',
            'status'=>'required',
            ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput(\Input::except('customer_contact'));
        }

        $ids = explode('_', $request->customer_contact);
        $customer_id = $ids[2];
        $location_id = $ids[1];
        $customer_contact_id = $ids[0];

       // dd( $ids);

        $ticket = new Ticket;
        $ticket->customer_location_contact_id = $customer_contact_id;
        $ticket->customer_id = $customer_id;
        
        $ticket->location_id= $location_id;
        $ticket->service_item_id= $request->service_item;
        $ticket->title= $request->title;
        $ticket->created_by= Auth::user()->id;
        $ticket->entered_date =   date("Y-m-d");
        $ticket->entered_time =  date('h:i:s');

        $ticket->body= $request->body;
        $ticket->ticket_status_id= $request->status;
        $ticket->priority= $request->priority;
        $ticket->save();
        foreach ($request->users as $user) {
            # code...
            if (!$user=='') {
                $ticket->assigned_to()->attach($user);
            }
        }
        $status = TicketStatus::find($ticket->ticket_status_id);
        $slack_msg = 'New ticket #'.$ticket->id.': '.$ticket->title.'<br/>';
        $slack_msg .= 'Description'.'<br/>';
        $slack_msg .= $ticket->body;
        $slack_msg .= 'Priority : '.$ticket->priority.'<br/>';
        $slack_msg .= 'Status : '.$status->title.'<br/>';

        $response = SlackChat::message($slack_channel->value, $slack_msg);
        //dd( $response);
        //$customer->service_items()->save($service_item);

        return redirect()->intended('admin/crm/ticket');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



        $ticket = Ticket::where('id', $id)->with(['assigned_to','attachments','entered_by','customer','location','service_item','customer_contact','entered_by.roles'])->first();
        $responses_result= Response::where('ticket_id', $id)->with(['responder'])->orderBy('entered_date', 'asc')->orderBy('entered_time', 'asc')->get();

        $responses = [];
        foreach ($responses_result as $response) {
            $responses[$response->entered_date][] = $response;
            # code...
        }

        $managers_obj =  Role::with('users')->where('name', 'manager')->orWhere('name', 'technician')->get();


        $users = [];
        $roles = [];

        if ($managers_obj->count()) {
            foreach ($managers_obj as $manager_obj) {
                foreach ($manager_obj->users as $user) {
                    $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                    //dd($user->id);
                }
            }
        }

        //dd($users);
        $assigned_users = [];
         //dd($ticket->assigned_to);
        foreach ($ticket->assigned_to as $assigned) {
            $assigned_users[]=$assigned->email;
                //dd($user->id);
        }

        $customers_records = Customer::where('is_active', 1)->get();
        $customers = [];
        foreach ($customers_records as $customer) {
              $customers[$customer->id]=$customer->name.' <'.$customer->email_domain.'>';
        }
        //dd($assigned_users);
        $customer_assigned = '';
        if ($ticket->customer) {
            $customer_assigned = $ticket->customer->id;
        }

        $tickets = [];
        $tickets_ = Ticket::where('id', '<>', $id)->get();
       // dd($tickets_);
        foreach ($tickets_ as $ticket_) {
            $tickets[$ticket_->id] = $ticket_->id.'. '.$ticket_->title;
        }


        $statuses_ = TicketStatus::all();
        $status_arr = [];
        if ($statuses_->count()) {
            foreach ($statuses_ as $status) {
                $obj = new \stdClass();
                $obj->id = $status->id;
                $obj->text = $status->title;
                $status_arr[] = $obj;
            }
        }
        $statuses = $status_arr;
        //var_dump($statuses);
        //exit;
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
        return view('crm::ticket.show.show', compact('ticket', 'users', 'assigned_users', 'responses', 'customers', 'customer_assigned', 'tickets', 'statuses', 'gmail_address'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMultiple(Request $request)
    {
        //dd($request->all());
        $ids_arr = explode(',', $request->ids);
        foreach ($ids_arr as $id) {
            # code...


            $ticket = Ticket::where('id', $id)->with(['responses','assigned_to','attachments','entered_by','customer','location','service_item','responses.responder'])->first();

            $ticket->responses()->delete();
            $ticket->attachments()->delete();
            $ticket->assigned_to()->delete();




            $ticket->delete();
        }
        

        return 'yes';
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $ticket = Ticket::where('id', $id)->with(['responses','assigned_to','attachments','entered_by','customer','location','service_item','responses.responder'])->first();

        $ticket->responses()->delete();
        $ticket->attachments()->delete();
        $ticket->assigned_to()->delete();




        $ticket->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        return redirect()->intended('admin/crm/ticket');
    }




    function addResponse(Request $request)
    {
        if ($request->original_ticket !='') {
            $original_ticket_record =  Ticket::where('id', $request->original_ticket)->first();
        }


        if ($request->original_ticket !='') {
               // dd('ff');
              $body .= '<p>Its duplicate of  <a href="'.URL::route('admin.ticket.show', $request->original_ticket).'">'.$original_ticket_record->title.'</a>';
        }

        $response_body = $request->body;
            //src="/ckfinder
            //dd($vv);
        $flag = $request->response_flag;
        $response = new Response;
        $response->ticket_id = $request->ticket_id;
        $response->body = htmlentities($response_body);
        $response->responder_id = Auth::user()->id;
        $response->entered_date =   date("Y-m-d");
        $response->entered_time =  date('h:i:s');
        if ($flag == 'note') {
            $response->response_type =  'note';
        }

        $response->save();

        $ticket = Ticket::where('id', $request->ticket_id)->with(['assigned_to','attachments','entered_by','customer','location','service_item'])->first();
        if ($request->original_ticket !='') {
            $ticket->status =  'closed';
            $ticket->save();
        }

        $responses_result= Response::where('ticket_id', $request->ticket_id)->with(['responder'])->orderBy('entered_date', 'asc')->get();

        $responses = [];
        foreach ($responses_result as $response) {
            $responses[$response->entered_date][] = $response;
                   # code...
        }
        $arr['success'] = 'Response Added successfully';

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

            //dd(config('mail'));
        $bcc =[];
        $cc = [];
        if ($flag =='reply') {
            $bcc = $request->bcc;
            $cc = $request->cc;
        }

        if ($ticket->type=='email' && $ticket->email!='' && $flag =='reply') {
            $variables = ["firstname"=>$ticket->sender_name,"lastname"=>"","response"=>$response_body];
            $email_body = Auth::user()->email_template;

            foreach ($variables as $key => $value) {
                $email_body = str_replace('%'.$key.'%', $value, $email_body);
            }

                    //echo $string;

            Mail::send('crm::ticket.email.response', ['body'=>$email_body], function ($message) use ($ticket, $gmail_address, $response, $bcc, $cc) {

                   /* $swiftMessage = $message->getSwiftMessage();
                    $headers = $swiftMessage->getHeaders();
                    $headers->addTextHeader('In-Reply-To', $ticket->gmail_msg_id);
                    $headers->addTextHeader('References', $ticket->gmail_msg_id);*/


                    $message->getHeaders()->addTextHeader('In-Reply-To', $ticket->gmail_msg_id);
                    $message->getHeaders()->addTextHeader('References', $ticket->gmail_msg_id);
                    $message->getHeaders()->addTextHeader('response_id', $response->id);
                if (count($bcc)>0) {
                    foreach ($bcc as $key => $bcc_email) {
                        $message->bcc(trim($bcc_email), $name = null);
                    }
                }
                if (count($cc)>0) {
                    foreach ($cc as $key => $cc_email) {
                        $message->cc(trim($cc_email), $name = null);
                    }
                }


                  $message->from(trim($gmail_address), Auth::user()->f_name.' '.Auth::user()->l_name);
                  $message->to(trim($ticket->email), $ticket->sender_name);
                  $message->subject($ticket->title);
            });
            if (count(Mail::failures()) > 0) {
                   echo "There was one or more failures. They were: <br />";

                foreach (Mail::failures() as $failure) {
                    echo " - $failure <br />";
                }
            }
        }

        if ($ticket->type=='ticket' && $flag =='reply') {
               $variables = ["firstname"=>$ticket->customer_contact->f_name,"lastname"=>$ticket->customer_contact->l_name,"response"=>$response_body];
               $email_body = Auth::user()->email_template;

            foreach ($variables as $key => $value) {
                 $email_body = str_replace('%'.$key.'%', $value, $email_body);
            }

                    //echo $string;


              Mail::send('crm::ticket.email.response', ['body'=>$email_body], function ($message) use ($ticket, $gmail_address, $response, $bcc, $cc, $request) {

                if (count($bcc)>0) {
                    foreach ($bcc as $key => $bcc_email) {
                        $message->bcc(trim($bcc_email), $name = null);
                    }
                }
                if (count($cc)>0) {
                    foreach ($cc as $key => $cc_email) {
                        $message->cc(trim($cc_email), $name = null);
                    }
                }



                $message->to(trim($request->to_email), $ticket->customer_contact->f_name.' '.$ticket->customer_contact->l_name)->subject($ticket->title)->from(trim($gmail_address), Auth::user()->f_name.' '.Auth::user()->l_name);
              });

            if (count(Mail::failures()) > 0) {
                       echo "There was one or more failures. They were: <br />";

                foreach (Mail::failures() as $failure) {
                    echo " - $failure <br />";
                }
            }
        }



        $view = view('crm::ticket.ajax_ticket_timeline', compact('ticket', 'responses'));
        $arr['html_content'] = (string) $view;
        return json_encode($arr);
        exit;
            //dd($responses);
            //return
    }


    function ajaxAssignCustomer(Request $request)
    {
        //dd($request->all());


          $this->validate(
              $request,
              [
              'customer_contact' => 'required',


              ]
          );

          $ids = explode('|', $request->customer_contact[0]);
          $customer_id = $ids[2];
          $location_id = $ids[1];
          $customer_contact_id = $ids[0];

          $ticket = Ticket::find($request->id);
          $ticket->customer_id = $customer_id;
          $ticket->location_id= $location_id;
          $ticket->customer_location_contact_id = $customer_contact_id;

          $ticket->save();

          $arr['success'] = 'Changed customer contact sussessfully';
          return json_encode($arr);
          exit;
    }


    function ajaxGetTicketById($id)
    {
         $ticket = Ticket::where('id', $id)->with(['assigned_to','status','attachments','entered_by','customer','location','service_item','customer_contact'])->first();
         $arr['ticket'] =  $ticket;
         return json_encode($arr);


         exit;
    }

    function ajaxAssignUsersMultiple(Request $request)
    {
        //dd($request->all());
        $this->validate(
            $request,
            [
            'users' => 'required',


            ]
        );
            $tickets = explode(',', $request->ids);

        foreach ($tickets as $ticket_id) {
            $ticket = Ticket::find($ticket_id);

            $ticket->assigned_to()->detach();
             //dd($request->users);
            foreach ($request->users as $key => $user) {
                    # code...
                if (!$user=='') {
                    $ticket->assigned_to()->attach($user);
                }
            }

            $ticket_ = Ticket::where('id', $ticket_id)->with(['assigned_to'])->first();

            $managers_obj =  Role::with('users')->where('name', 'manager')->orWhere('name', 'technician')->get();

              // dd($ticket_->assigned_to);
            $users = [];
            if ($managers_obj->count()) {
                foreach ($managers_obj as $manager_obj) {
                    foreach ($manager_obj->users as $user) {
                            //if($user->id == )
                        $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                        //dd($user->id);
                    }
                }
            }

            $assigned_users = [];

            if ($ticket_->assigned_to->count()!=0) {
                foreach ($ticket_->assigned_to as $key => $assigned) {
                    //dd($assigned);
                    $assigned_users[$assigned->id]=$users[$assigned->id];
                }
            }
        }


            //dd($ticket_);
            $arr['success'] = 'Assigned Users to tickets sussessfully';
            //$arr['assigned_users'] =  $assigned_users;
            //$arr['ticket_id'] =  $request->id;
            return json_encode($arr);


            exit;
    }
    function ajaxAssignUsers(Request $request)
    {
        //dd($request->all());
        $this->validate(
            $request,
            [
            'users' => 'required',


            ]
        );

            $ticket = Ticket::find($request->id);

            $ticket->assigned_to()->detach();
             //dd($request->users);
        foreach ($request->users as $key => $user) {
                # code...
            if (!$user=='') {
                $ticket->assigned_to()->attach($user);
            }
        }

            $ticket_ = Ticket::where('id', $request->id)->with(['assigned_to'])->first();

            $managers_obj =  Role::with('users')->where('name', 'manager')->orWhere('name', 'technician')->get();

              // dd($ticket_->assigned_to);
            $users = [];
        if ($managers_obj->count()) {
            foreach ($managers_obj as $manager_obj) {
                foreach ($manager_obj->users as $user) {
                        //if($user->id == )
                    $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                    //dd($user->id);
                }
            }
        }

            $assigned_users = [];

        if ($ticket_->assigned_to->count()!=0) {
            foreach ($ticket_->assigned_to as $key => $assigned) {
                    //dd($assigned);
                $assigned_users[$assigned->id]=$users[$assigned->id];
            }
        }


            //dd($ticket_);
            $arr['success'] = 'Assigned Users to ticket sussessfully';
            $arr['assigned_users'] =  $assigned_users;
            $arr['ticket_id'] =  $request->id;
            return json_encode($arr);


            exit;
    }

    function ajaxUpdateStatusMultiple(Request $request)
    {
        /*$this->validate($request,
            [
                'users' => 'required',


                ]);*/
        if ($request->multi_status_ids) {
            $tickets = explode(',', $request->multi_status_ids);

            foreach ($tickets as $ticket_id) {
                $ticket = Ticket::find($ticket_id);

                $ticket->ticket_status_id = $request->status;
                //$ticket->priority= $request->priority;
                $ticket->save();
            }
        }





             $arr['success'] = 'Changed status sussessfully';

             return json_encode($arr);


             exit;
    }

    function ajaxUpdatePriorityMultiple(Request $request)
    {
        if ($request->multi_priority_ids) {
            $tickets = explode(',', $request->multi_priority_ids);

            foreach ($tickets as $ticket_id) {
                $ticket = Ticket::find($ticket_id);


                $ticket->priority= $request->priority;
                $ticket->save();
            }
        }

        $arr['success'] = 'Changed priority sussessfully';

        return json_encode($arr);


        exit;
    }
    function ajaxUpdateTitle(Request $request)
    {
        //dd($request->all());
        if ($request->name=='change_title') {
            $ticket_ = Ticket::find($request->pk);

            $ticket_->title= $request->value;
            $ticket_->save();
        }

        return 'ok';
        exit;
    }
    function ajaxUpdateStatusPriority(Request $request)
    {
        //dd($request->all());
        if ($request->name=='ticket_priority') {
            $ticket_ = Ticket::find($request->pk);

            $ticket_->priority= $request->value;
            $ticket_->save();
        }
        if ($request->name=='ticket_status') {
            $ticket_ = Ticket::find($request->pk);

            $ticket_->ticket_status_id = $request->value;

            $ticket_->save();
        }


        return 'ok';
        exit;
    }

    function ajaxDeleteAssignedUser($t_id, $u_id)
    {
        $ticket = Ticket::find($t_id);
        $ticket->assigned_to()->detach([$u_id]);

        $ticket_ = Ticket::where('id', $t_id)->with(['assigned_to'])->first();

        $managers_obj =  Role::with('users')->where('name', 'manager')->orWhere('name', 'technician')->get();

              // dd($ticket_->assigned_to);
        $users = [];
        if ($managers_obj->count()) {
            foreach ($managers_obj as $manager_obj) {
                foreach ($manager_obj->users as $user) {
                            //if($user->id == )
                    $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                        //dd($user->id);
                }
            }
        }

        $assigned_users = [];

        if ($ticket_->assigned_to->count()!=0) {
            foreach ($ticket_->assigned_to as $key => $assigned) {
                        //dd($assigned);
                $assigned_users[$assigned->id]=$users[$assigned->id];
            }
        }


                //dd($ticket_);
        $arr['success'] = 'Employee successfully detached';
        $arr['assigned_users'] =  $assigned_users;
        $arr['ticket_id'] =  $t_id;
        return json_encode($arr);
    }

    function ajaxDeleteAssignedCustomer($t_id)
    {
         $ticket = Ticket::find($t_id);
         $ticket->customer_id = 0;
         $ticket->save();

         $ticket_ = Ticket::where('id', $t_id)->with(['customer'])->first();


        //dd($ticket_);
         $arr['success'] = 'Customer detached from ticket sussessfully';
         $arr['customer_assigned'] =  '';
         $arr['ticket_id'] =  $t_id;
         return json_encode($arr);


         exit;
    }

    function readGmail()
    {


         $gmail = new GoogleGmail();
        //$emails = $gmail->getMessages();0
         $threads = $gmail->getThreads();



        foreach ($threads as $key => $thread) {
              //dd();
            foreach ($thread as $email) {
                 //dd($email);
                $already_imported=GmailEmailLog::where('gmail_msg_id', $email['gmail_msg_id'])->count();

                $body =$email['body'];
                if (!$already_imported) {
                    if ($key==$email['messageId']) {
                           //dd($key);
                          $chk_ticket = Ticket::where('gmail_msg_id', $email['gmail_msg_id'])->first();
                           //dd($chk_ticket);
                        if (!$chk_ticket) {
                            $customer_email = $email['messageSenderEmail'];

                            $customer = Customer::where('email_domain', $customer_email)->first();

                            if ($customer) {
                                $customer_id = $customer->id;
                            }

                            $ticket = new Ticket;
                            if ($customer) {
                                  $ticket->customer_id = $customer_id;//$request->customer_id;
                            } else {
                                $ticket->email = $customer_email;
                                $ticket->sender_name = $email['messageSender'];
                            }
                            $email_log= new GmailEmailLog;
                            $email_log->gmail_msg_id=$email['gmail_msg_id'];
                            $email_log->save();
                            $ticket->gmail_msg_id = $email['gmail_msg_id'];

                            $ticket->entered_date=  date('Y-m-d', strtotime($email['revceived_date']));
                            $ticket->entered_time = date('h:i:s', strtotime($email['revceived_date']));

                            $ticket->title= $email['title'];

                            $ticket->body= $body;
                            $ticket->type= 'email';

                            $ticket->thread_id= $key;

                            $status = TicketStatus::where('title', 'new')->first();

                            $ticket->ticket_status_id = $status->id;
                            $ticket->priority= 'normal';
                             //dd($ticket);
                            $ticket->save();
                            $ticket_id  = $ticket->id;
                            if ($email['attachments']) {
                                foreach ($email['attachments'] as $attachment) {
                                       // $body .= urlencode('<a href="'.url('/')."/attachments/$attachment".'"  data-lightbox="$attachment"><img src="'.url('/')."/attachments/$attachment".'" /> </a>');

                                    $new_attachment = new Attachment;
                                    $new_attachment->name = $attachment['name'];
                                    $new_attachment->type = $attachment['mime_type'];
                                    $ticket->attachments()->save($new_attachment);
                                }
                            }
                        }
                    } else {
                        if ($chk_ticket) {
                            $ticket_id = $chk_ticket->id;
                        }


                           //check if gmial_msg_id exist, it means its customer earlier reply/response to our/employee reponse.
                        $check_response_already_exist = Response::where('gmail_msg_id', $email['gmail_msg_id'])->first();
                        if (!$check_response_already_exist) {
                                  //check if response_id exist, it means that its response and already exist in database.
                              $chk_reponse_by_id = Response::find($email['response_id']);
                            if (!$chk_reponse_by_id) {
                                $_ticket = Ticket::where('thread_id', $key)->first();
                                $status = TicketStatus::where('title', 'open')->first();
                                $_ticket->ticket_status_id= $status->id;
                                $_ticket->save();
                                $response = new Response;
                                $response->ticket_id = $ticket_id;
                                $response->body =  $body;
                                $response->sender_type = 'customer';
                                $response->entered_date = date('Y-m-d', strtotime($email['revceived_date']));
                                $response->entered_time = date(' h:i:s', strtotime($email['revceived_date']));
                                $email_log= new GmailEmailLog;
                                $email_log->gmail_msg_id=$email['gmail_msg_id'];
                                $email_log->save();
                                $response->gmail_msg_id = $email['gmail_msg_id'];
                                $response->save();
                            }
                        }
                    }
                }
            }
        }
        $arr['success'] = 'Tickets added sussessfully from email';

        return json_encode($arr);
        exit;
    }


    function ajaxGetContacts(Request $request)
    {
          //dd($request->customer_contact);
          $name = $request->customer_contact;





        if (!empty(Session::get('cust_id'))) {
            $customers = Customer::with(['locations.contacts'=>function ($query) use ($name) {
                $query->where('f_name', 'like', '%'.$name.'%')->orWhere('l_name', 'like', '%'.$name.'%');
            }])->where('is_active', 1)->where('id', Session::get('cust_id'))->get();
        } else {
            $customers = Customer::with(['locations.contacts'=>function ($query) use ($name) {
                        $query->where('f_name', 'like', '%'.$name.'%')->orWhere('l_name', 'like', '%'.$name.'%');
            }])->where('is_active', 1)->get();
        }

        $contacts = [];
        foreach ($customers as $customer) {
            foreach ($customer->locations as $location) {
                if (count($location->contacts)>0) {
                    foreach ($location->contacts as $contact) {
                        $contacts [] = ['id'=>$contact->id.'_'.$location->id.'_'.$customer->id,
                        'name'=>$contact->f_name.' '.$contact->l_name,
                        'customer'=>$customer->name,
                        'location'=> $location->location_name,
                        'country' =>$location->country,
                        'city'=>$location->city];
                    }
                }
            }
                       # code...
        }

        return json_encode($contacts);
    }


    function searchTickets(Request $request)
    {

        if ($request->ticket) {
            $tickets_result = Ticket::with('customer')->where('title', 'like', '%'.$request->ticket.'%')->orWhere('body', 'like', '%'.$request->ticket.'%')->get();



            $tickets = [];
            foreach ($tickets_result as $ticket) {
                $ticket_arr['id'] = $ticket->id;
                if ($ticket->customer) {
                    $ticket_arr['ticket_title'] = $ticket->title.' ('.$ticket->customer->name.')';
                }
                if ($ticket->type =='email') {
                    $ticket_arr['ticket_title'] = $ticket->title.' ('.$ticket->email.')';
                }


                $tickets[] = $ticket_arr;
            }

            echo json_encode([
            "status" => true,
            "error"  => null,
            "data"   => [
                "tickets"   => $tickets
                ]
            ]);
        } else {
            echo json_encode([
            "status" => true,
            "error"  => null,
            "data"   => [
            "tickets"   => []
            ]
            ]);
        }
    }

    function getContactsByLoc($loc_id)
    {
          $location = CustomerLocation::with('contacts')->where('id', $loc_id)->first();
          //dd($location);
          $loc_contacts = [];
        foreach ($location->contacts as $contact) {
            $loc_contacts[]= ['id'=>$contact->id,
            'text'=>$contact->f_name.' '.$contact->l_name];
        }

        return json_encode($loc_contacts);
        exit;
    }


    public function addTicket(Request $request)
    {
        //dd($request->all());

        $slack_channel =  Config::where('key', 'channel')->where('title', 'slack')->first();

        $slack_access_token =  Config::where('key', 'access_token')->where('title', 'slack')->first();

        config(['services.slack.token' => $slack_access_token->value]);

        //$slack_msg = 'New ticket created :'.$ticket->title;

        $this->validate(
            $request,
            [
            'ticket_location_contact' => 'required',
            'ticket_subject'=>'required',

            'ticket_status'=>'required',

            ]
        );




        $customer_id = Session::get('cust_id');
        $location_id = $request->ticket_location;
        $customer_contact_id = $request->ticket_location_contact;

           // dd( $ids);

        $ticket = new Ticket;
        $ticket->customer_location_contact_id = $customer_contact_id;
        $ticket->customer_id = $customer_id;

        $ticket->location_id= $location_id;
        $ticket->service_item_id= $request->ticket_service_item;
        $ticket->title= $request->ticket_subject;
        $ticket->created_by= Auth::user()->id;
        $ticket->entered_date =   date("Y-m-d");
        $ticket->entered_time =  date('h:i:s');

        $ticket->body= $request->notes;
        $ticket->ticket_status_id= $request->ticket_status;
        $ticket->priority= $request->ticket_priority;
        $ticket->save();
        foreach ($request->ticket_assign as $user) {
            # code...
            if (!$user=='') {
                $ticket->assigned_to()->attach($user);
            }
        }
        $status = TicketStatus::find($ticket->ticket_status_id);
        $slack_msg = 'New ticket #'.$ticket->id.': '.$ticket->title.'<br/>';
        $slack_msg .= 'Description'.'<br/>';
        $slack_msg .= $ticket->body;
        $slack_msg .= 'Priority : '.$ticket->priority.'<br/>';
        $slack_msg .= 'Status : '.$status->title.'<br/>';

        $response = SlackChat::message($slack_channel->value, $slack_msg);
        //dd( $response);
        //$customer->service_items()->save($service_item);
        return json_encode(['success'=>'yes']);
        //return redirect()->intended('admin/crm/ticket');
    }
}
