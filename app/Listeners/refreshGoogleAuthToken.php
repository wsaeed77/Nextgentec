<?php

namespace App\Listeners;

use App\Events\updateGoogleAuthToken;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Config;
use App\Services\GoogleGmail;
class refreshGoogleAuthToken
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  updateGoogleAuthToken  $event
     * @return void
     */
    public function handle(updateGoogleAuthToken $event)
    {
        //
        $google_auth_arr = Config::where('title','google_auth')->get();
       
        $google_auth =[];
        foreach ($google_auth_arr as $value) {
            if($value->key=='gmail_auth_client_id')
                $google_auth['gmail_auth_client_id'] = $value->value;
            if($value->key=='gmail_auth_client_secret')
                $google_auth['gmail_auth_client_secret'] = $value->value;
            
        }


          $file_path              = base_path('resources/assets');
            $file['client_id']      = $google_auth['gmail_auth_client_id'];
            $file['client_secret']  = $google_auth['gmail_auth_client_secret'];
            $file['redirect_uris']  = [\URL::route('get_token')];
            $str_to_json['web']     = $file;
           // dd($file);
            //dd($file_path."client_secret.json");
           try
              {
                //file_put_contents($file_path."client_secret.json",  json_encode($file);

                        $myfile = fopen($file_path."/client_secret.json", "w") or die("Unable to open file!");

                        
                        fwrite($myfile, json_encode($str_to_json,JSON_UNESCAPED_SLASHES));
                        
                        
                        fclose($myfile);
            }
               catch (Exception $e) 
               {
                        echo 'Caught exception: ',  $e->getMessage(), "\n";
               }


             $gmail = new GoogleGmail('reset');

            //dd($response);
               return compact("gmail");
    }
}
