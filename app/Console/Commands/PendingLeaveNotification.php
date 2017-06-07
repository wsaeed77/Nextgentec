<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Modules\Employee\Http\Employee;
use App\Modules\Employee\Http\Leave;


use App\Model\Config;
use Auth;
use Mail;

class PendingLeaveNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:leavenotify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $leaves = Leave::where('status', 'pending')->with(['user', 'user.roles'])->get();
         //dd($leaves[0]->user->roles);
       //$gmail_address='w.saeed77@gmail.com';

        $smtp_arr = Config::where('title', 'smtp')->get();
        $email_body='wasdasdasdasdasd';
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



        Mail::send('crm::ticket.email.response', array('body'=>$email_body), function ($message) use ($gmail_address) {

                   /* $swiftMessage = $message->getSwiftMessage();
                    $headers = $swiftMessage->getHeaders();
                    $headers->addTextHeader('In-Reply-To', $ticket->gmail_msg_id);
                    $headers->addTextHeader('References', $ticket->gmail_msg_id);*/


                    // $message->getHeaders()->addTextHeader('In-Reply-To', $ticket->gmail_msg_id);
                    // $message->getHeaders()->addTextHeader('References', $ticket->gmail_msg_id);
                    // $message->getHeaders()->addTextHeader('response_id', $response->id);
                


              $message->from(trim($gmail_address), 'waqas saeed');
              $message->to('w.saeed77@gmail.com', 'waqas saeed');
              $message->subject('pending email notification');
        });
    }
}
