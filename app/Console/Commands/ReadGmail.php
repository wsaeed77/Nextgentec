<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleGmail;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\Ticket;
use App\Modules\Crm\Http\Response;

use App\Modules\Crm\Http\Attachment;
use App\Events\updateGoogleAuthToken;
use App\Model\Config;
use Auth;
use Mail;
use Event;
use App\Modules\Crm\Http\TicketStatus;

class ReadGmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:read';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read and store GMAIL emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
          $gmail = new GoogleGmail();
      
         $threads = $gmail->getThreads();

    // dd($threads);
        foreach ($threads as $key => $thread) {
            //dd();
            foreach ($thread as $email) {
                 //dd($email);

                $body =$email['body'];

                if ($key==$email['messageId']) {
                    $chk_ticket = Ticket::where('gmail_msg_id', $email['gmail_msg_id'])->first();
                  
                    if (!$chk_ticket) {
                        $customer_email = $email['messageSenderEmail'];

                        $customer = Customer::where('email_domain', $customer_email)->first();
                        //dd($customer);
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
                        //$ticket->location_id= $request->location;
                        //$ticket->service_item_id= $request->service_item;

                        $ticket->gmail_msg_id = $email['gmail_msg_id'];

                        $ticket->entered_date=  date('Y-m-d', strtotime($email['revceived_date']));
                        $ticket->entered_time = date('h:i:s', strtotime($email['revceived_date']));

                        $ticket->title= $email['title'];

                        //$ticket->created_by= 4;//Auth::user()->id;
                        $ticket->body= $body;
                         $ticket->type= 'email';

                         $ticket->thread_id= $key;

                         $status = TicketStatus::where('title', 'new')->first();

                        $ticket->ticket_status_id = $status->id;
                        $ticket->priority= 'normal';
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

                            $response->gmail_msg_id = $email['gmail_msg_id'];
                            $response->save();
                        }
                    }
                }
            }
        }
         //$arr['success'] = 'Tickets added sussessfully from email';
          //$arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates',compact('service_items'))->render();
          // return json_encode($arr)

      //dd('lll-here');
        
       /* $smtp_arr = Config::where('title','smtp')->get();
       
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
           

            

                 Mail::send('crm::ticket.email.response', array('firstname'=>'asad','body'=>'cronjob email from 216.238.153.54'), function($message) use($gmail_address) {


                    $message->to('adnan.nexgentec@nxvt.com','adnan')->subject('cronjob test')->from($gmail_address,'cronjob');
                });
 */
        echo 'done';
        exit;
    }
}
