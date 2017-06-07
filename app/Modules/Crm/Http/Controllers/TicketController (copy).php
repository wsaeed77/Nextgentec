<?php
namespace App\Modules\Crm\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\Employee;

use App\Modules\Crm\Http\Ticket;
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
class TicketController extends Controller
{
    
	public function index()
	{
       
       
        $tickets = Ticket::with(['responses','assigned_to','entered_by','customer','location','service_item'])->paginate(10);
        //dd($tickets);
      
        return view('crm::ticket.index',compact('tickets'));
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
         if($customers_obj->count())
        {
            foreach($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                //dd($user->id);
            }

        }

        $managers_obj =  Role::with('users')->where('name','manager')->orWhere('name','technician')->get();

      // dd($managers_obj);
        $users = [];
        $roles = [];
        //if ($manager->users->count())
        //$managers = $manager->users;
        if($managers_obj->count())
        {
            foreach($managers_obj as $manager_obj) {
                foreach($manager_obj->users as $user) {
                $users[$user->id]=$user->f_name." ".$user->l_name.'('.$manager_obj->name.')';
                //dd($user->id);
            }
        }

        }

       
        return view('crm::ticket.add',compact('customers','users'));
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

        $this->validate($request, 
            [
                'customer_id' => 'required',
                'title'=>'required',
                'body'=>'required',
               
                
            ]);

       $ticket = new Ticket;
        $ticket->customer_id = $request->customer_id;
        $ticket->location_id= $request->location;
        $ticket->service_item_id= $request->service_item;
        $ticket->title= $request->title;
        $ticket->created_by= Auth::user()->id;
        $ticket->body= $request->body;
        $ticket->status= 'new';
        $ticket->priority= $request->priority;
        $ticket->save();
        foreach ($request->users as $user) {
            # code...
            if(!$user=='')
            $ticket->assigned_to()->attach($user);
        }
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
        $ticket = Ticket::where('id',$id)->with(['responses','assigned_to','attachments','entered_by','customer','location','service_item','responses.responder'])->first();
        //dd($tickets[0]->created_by);
      //dd($ticket);
         $managers_obj =  Role::with('users')->where('name','manager')->orWhere('name','technician')->get();

      // dd($managers_obj);
        $users = [];
        $roles = [];
        //if ($manager->users->count())
        //$managers = $manager->users;
        if($managers_obj->count())
        {
            foreach($managers_obj as $manager_obj) {
                foreach($manager_obj->users as $user) {
                $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                //dd($user->id);
                }
            }

        }
         $assigned_users = [];
        foreach($ticket->assigned_to as $assigned) {
               
                $assigned_users[]=$assigned->id;
                //dd($user->id);
               
            }

       
        //dd($assigned_users);
        return view('crm::ticket.show',compact('ticket','users','assigned_users'));
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
        $id = $request->id;
        $ticket = Ticket::where('id',$id)->with(['responses','assigned_to','attachments','entered_by','customer','location','service_item','responses.responder'])->first();

        $ticket->responses()->delete();
        $ticket->attachments()->delete();
         $ticket->assigned_to()->delete();

      
       

       $ticket->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        return redirect()->intended('admin/crm/ticket');
    }

  
   

     function addResponse(Request $request)
     {
        
        $site_path = URL::to('/');
            //dd($request->all());
            $pattern = '/\/ckfinder/';
            $replacement = $site_path.'/ckfinder';
            $body = $request->body;

             //preg_match( $pattern, $body, $output_array);
//dd($output_array);

            $response_body = preg_replace($pattern, $replacement, $body);
//src="/ckfinder
            //dd($vv);
            $response = new Response;
            $response->ticket_id = $request->ticket_id;
            $response->body = htmlentities($response_body);
            $response->responder_id = Auth::user()->id;
            $response->save();

            $responses_ = Response::with(['responder'])->where('ticket_id',$request->ticket_id)->orderBy('created_at', 'desc')->get();
            $responses =[];
            foreach ($responses_ as $response) {

                $responses[]=['name'=>$response->responder->f_name,
                              'body'=>html_entity_decode($response->body),
                              'response_time' => date('d/m/Y  h:i A',strtotime($response->created_at))
                              ];

               }
            $arr['success'] = 'Response Added successfully';
            $arr['responses'] = $responses;


            $ticket = Ticket::find($request->ticket_id);

            $smtp_arr = Config::where('title','smtp')->get();
       
            $smtp =[];
            foreach ($smtp_arr as $value) {
                if($value->key=='server_address')
                    $server_address = $value->value;
                if($value->key=='gmail_address')
                    $gmail_address = $value->value;
                if($value->key=='gmail_password')
                    $password = $value->value;
                if($value->key=='port')
                    $port= $value->value;
            }

            config(['mail.driver' => 'smtp',
                    'mail.host' => $server_address,
                    'mail.port' => $port,
                    'mail.encryption' => 'ssl',
                    'mail.username' => $gmail_address,
                    'mail.password' => $password]);

            if($ticket->type=='email' && $ticket->email!='')
            {

                $envelope["from"]=$gmail_address ;
                $envelope["to"]  = $ticket->email;
                $envelope["in_reply_to"]  = "56F15324.7050704@nxvt.com";

               $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html;' . "\r\n";
                $headers .= 'From: '.Auth::user()->f_name.' '.Auth::user()->l_name.'<'.$gmail_address.'>'." \r\n" .
                            //'Reply-To:  <'.$gmail_address.'>'. "\r\n" .
                           // 'Subject: '.$ticket->title."\r\n".
                            'To: '.$ticket->email."\r\n".
                            'In-Reply-To:'.$ticket->gmail_msg_id. "\r\n" .
                            'References:'.$ticket->gmail_msg_id. "\r\n" .
                            //'threadId:1543e7f8d480bc92'. "\r\n" .
                            'Return-Path:<'.$gmail_address.">\r\n" .
                            'X-Mailer: PHP/' . phpversion();
              
                //imap_mail ( $ticket->email , $ticket->title ,$response_body,$headers);

                               $strRawMessage = "";
                              $boundary = uniqid(rand(), true);
                              $subjectCharset = $charset = 'utf-8';


                               $strRawMessage .= 'To: ' . $this->encodeRecipients(" <" . $ticket->email . ">") . "\r\n";
                            $strRawMessage .= 'From: '. $this->encodeRecipients(Auth::user()->f_name.' '.Auth::user()->l_name ." <" . $gmail_address . ">") . "\r\n";

                            $strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($ticket->title) . "?=\r\n";
                            $strRawMessage .= 'MIME-Version: 1.0' . "\r\n";
                            $strRawMessage .='In-Reply-To:'.$ticket->gmail_msg_id. "\r\n" ;
                            $strRawMessage .='References:'.$ticket->gmail_msg_id. "\r\n" ;
                            $strRawMessage .= 'Content-type: Multipart/Alternative; boundary="' . $boundary . '"' . "\r\n";

                            $strRawMessage .= "\r\n--{$boundary}\r\n";
                            $strRawMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
                            $strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";

                            $strRawMessage .= $response_body. "\r\n";

                           /* $mimeMessage  = "MIME-Version: 1.0\r\n";
                            $mimeMessage  .= 'From: '.Auth::user()->f_name.' '.Auth::user()->l_name.'<'.$gmail_address.'>'."\r\n";
                            $mimeMessage .= "To:  <".$ticket->email.">\r\n";
                            $mimeMessage .= "Subject: =?utf-8?B?".base64_encode($ticket->title)."?=\r\n";
                            $mimeMessage .= "Date: ".date(DATE_RFC2822)."\r\n";
                            $mimeMessage .= "Content-Type: multipart/mixed; boundary=test\r\n\r\n";
                            $mimeMessage .= "--test\r\n";
                              $mimeMessage .='Message-ID:'.$ticket->gmail_msg_id. "\r\n" ;
                             $mimeMessage .='In-Reply-To:'.$ticket->gmail_msg_id. "\r\n" ;
                             $mimeMessage .='References:'.$ticket->gmail_msg_id. "\r\n" ;
                             //$mimeMessage .='threadId:1543e7f8d480bc92'. "\r\n" ;
                            $mimeMessage .= "Content-Type: text/plain; charset=UTF-8\r\n";
                            $mimeMessage .= "Content-Transfer-Encoding: base64\r\n\r\n";
                            $mimeMessage .= $response_body."\r\n";

                            //rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
                            //$mimeMessageEncoded = base64url_encode($mimeMessage);
                            $mimeMessageEncoded = rtrim(strtr(base64_encode($mimeMessage), '+/', '-_'), '=');*/

                              $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');

                           //$gmail = new GoogleGmail();
                           //$gmail->send_mail($mime,'15452dee85caef8d');
                           
                        //exit;

           Mail::send('crm::ticket.email.response', array('firstname'=>$ticket->sender_name,'body'=>$response_body), function($message) use ($ticket,$gmail_address){

            $swiftMessage = $message->getSwiftMessage();
            $headers = $swiftMessage->getHeaders();
            $headers->addTextHeader('In-Reply-To', $ticket->gmail_msg_id);
            $headers->addTextHeader('References', $ticket->gmail_msg_id);
            $message->to($ticket->email,$ticket->sender_name)->subject($ticket->title)->from($gmail_address,Auth::user()->f_name.' '.Auth::user()->l_name);
        });
       }

            return json_encode($arr);
            exit;
            //dd($responses);
            //return 
     }

     function encodeRecipients($recipient){
    $recipientsCharset = 'utf-8';
    if (preg_match("/(.*)<(.*)>/", $recipient, $regs)) {
        $recipient = '=?' . $recipientsCharset . '?B?'.base64_encode($regs[1]).'?= <'.$regs[2].'>';
    }
    return $recipient;
}

    function ajaxAssignUsers(Request $request)
    {
        //dd($request->all());
        $this->validate($request, 
            [
                'users' => 'required',
                
                
            ]);

        $ticket = Ticket::find($request->id);
        //$ticket->customer_id = $request->customer_id;
        //$ticket->location_id= $request->location;
        //$ticket->service_item_id= $request->service_item;
        //$ticket->title= $request->title;
        //$ticket->created_by= Auth::user()->id;
        //$ticket->body= $request->body;
        //$ticket->status= 'new';
        //$ticket->priority= $request->priority;
        $ticket->save();
        $ticket->assigned_to()->detach();
        foreach ($request->users as $user) {
            # code...
            if(!$user=='')
            {
                $ticket->assigned_to()->attach($user);
            }
        }
        //$customer->service_items()->save($service_item);

        //return redirect()->intended('admin/crm/ticket'); 
        $ticket_ = Ticket::where('id',$request->id)->with(['assigned_to'])->first();

        $managers_obj =  Role::with('users')->where('name','manager')->orWhere('name','technician')->get();

      // dd($ticket_->assigned_to);
        $users = [];
        if($managers_obj->count())
        {
            foreach($managers_obj as $manager_obj) {
                foreach($manager_obj->users as $user) {
                    //if($user->id == )
                $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                //dd($user->id);
            }
        }

        }

        $assigned_users = [];

        if($ticket_->assigned_to->count()!=0)
        {
            foreach($ticket_->assigned_to as $key=>$assigned) {
               
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


    function ajaxUpdateStatusPriority(Request $request)
    {
       // dd($request->all());
         $ticket_ = Ticket::find($request->id);
        //$ticket->customer_id = $request->customer_id;
        //$ticket->location_id= $request->location;
        //$ticket->service_item_id= $request->service_item;
        //$ticket->title= $request->title;
        //$ticket->created_by= Auth::user()->id;
        //$ticket->body= $request->body;
        $ticket_->status= $request->status;
        $ticket_->priority= $request->priority;
        $ticket_->save();

         $ticket = Ticket::where('id',$request->id)->first();
        $btn_class =  '';
        if($ticket->priority == 'low')
          $btn_class = 'bg-gray';
        if($ticket->priority == 'normal')
          $btn_class = 'bg-blue';
        if($ticket->priority == 'high')
          $btn_class = 'bg-green';
        if($ticket->priority == 'urgent')
          $btn_class = 'bg-yellow';
        if($ticket->priority == 'critical')
          $btn_class = 'bg-red';
        
         $arr['success'] = 'Changed status/priority sussessfully';
         $arr['btn_class_priority'] =  $btn_class;
         $arr['ticket'] =  $ticket;
         $arr['ticket_id'] =  $request->id;
        return json_encode($arr);

       
        exit;

    }

    function ajaxDeleteAssignedUser($t_id,$u_id)
    {
             $ticket = Ticket::find($t_id);
              $ticket->assigned_to()->detach([$u_id]);

             $ticket_ = Ticket::where('id',$t_id)->with(['assigned_to'])->first();

                $managers_obj =  Role::with('users')->where('name','manager')->orWhere('name','technician')->get();

              // dd($ticket_->assigned_to);
                $users = [];
                if($managers_obj->count())
                {
                    foreach($managers_obj as $manager_obj) {
                        foreach($manager_obj->users as $user) {
                            //if($user->id == )
                        $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                        //dd($user->id);
                    }
                }

                }

                $assigned_users = [];

                if($ticket_->assigned_to->count()!=0)
                {
                    foreach($ticket_->assigned_to as $key=>$assigned) {
                       
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



     function readGmail()
     {

       

        //dd(url('/'));
        //$gmail = new GoogleGmail();
        $gmail = new ImapGmail();
        $emails = $gmail->getMessages();
     // dd($emails);

       
        foreach ($emails as $email) {
            $body =$email['body'];
            $customer_email = $email['messageSenderEmail'];
            
            $customer = Customer::where('email_domain',$customer_email)->first();
            //dd($customer);
            if($customer)
            {
                $customer_id = $customer->id;
            }
            

            $ticket = new Ticket;
            if($customer)
              $ticket->customer_id = $customer_id;//$request->customer_id;
            else
            {
                $ticket->email = $customer_email;
                $ticket->sender_name = $email['messageSender'];
            }
            //$ticket->location_id= $request->location;
            //$ticket->service_item_id= $request->service_item;

            $ticket->gmail_msg_id = $email['message_id'];
       
            $ticket->title= $email['title'];
            //$ticket->created_by= 4;//Auth::user()->id;
            $ticket->body= $body;
             $ticket->type= 'email';
             

            $ticket->status= 'new';
            $ticket->priority= 'low';
             $ticket->save();
            if($email['attachments'])
            {
                foreach ($email['attachments'] as $attachment) {
                   // $body .= urlencode('<a href="'.url('/')."/attachments/$attachment".'"  data-lightbox="$attachment"><img src="'.url('/')."/attachments/$attachment".'" /> </a>');

                    $new_attachment = new Attachment;
                    $new_attachment->name = $attachment['name'];
                    $new_attachment->type = $attachment['mime_type'];
                    $ticket->attachments()->save($new_attachment);


                }
                
            }

        }
         $arr['success'] = 'Tickets added sussessfully from email';
          //$arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates',compact('service_items'))->render();
           return json_encode($arr);
        exit; 
     }
}


