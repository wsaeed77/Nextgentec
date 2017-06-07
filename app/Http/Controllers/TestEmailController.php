<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Model\Config;
use App\Services\GoogleGmail;
use App\Services\ImapGmail;
use URL;
use Mail;
use Auth;

class TestEmailController extends Controller
{

    function sendEmail()
    {

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
                    'mail.from' =>['address'=>$gmail_address,'name'=>'Nexgentec']
                    ]);

                //echo '<pre>';
                //dd(config('mail'));
                
              Mail::send('crm::ticket.email.response', ['body'=>'just test test email, by clicking test email button on show ticket page.'], function ($m) use ($gmail_address) {
                    $m->from($gmail_address, 'Nexgentec');

                    $m->to('mmanning@nexgentec.com', 'Adnan Tahir')->subject('Your Reminder!');
              });

          dd(Mail::failures());
         /*   if( count(Mail::failures()) > 0 ) {

                       echo "There was one or more failures. They were: <br />";

                       foreach(Mail::failures() as $failure) {
                           echo " - $failure <br />";
                        }

                    } else {
                        echo "No errors, all sent successfully!";
                    }*/
    }
}
