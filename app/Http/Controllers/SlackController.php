<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Model\Config;

use App\Model\User;

use Auth;
use SlackApi;
use Redirect;
use URL;

class SlackController extends Controller
{
    function getForm()
    {
      //$zoho = Config::where('title','zoho')->get();
      $slack_record = Config::where('title','slack')->get();
            $slack_arr=[];
           foreach ($slack_record as $value) {
           if($value->key=='client_id')
                $slack_arr['client_id'] = $value->value;
            if($value->key=='secret')
                $slack_arr['secret'] = $value->value;
            if($value->key=='redirect_uri')
                $slack_arr['redirect_uri'] = $value->value;
            if($value->key=='channel')
                $slack_arr['channel'] = $value->value;
            if($value->key=='access_token')
                $slack_arr['access_token'] = $value->value;
           
            }
 //dd($zoho_arr);
        //$zoho = Zoho::first();

         return view('admin.setting.slack.add',compact('slack_arr'))->render();
    }


    function slackStore(Request $request)
    {

        //$id = $request->zoho_id;
        $this->validate($request,
            [
                'client_id' => 'required',
                'secret' => 'required',
                'redirect_uri' => 'required',
                //'channel' => 'required',


            ]);

        //dd($request->all());
            $slack_client_id =  Config::where('key','client_id')->where('title','slack')->first();
            $slack_client_id->value  = $request->client_id;
            $slack_client_id->save();
       
            $slack_secret =  Config::where('key','secret')->where('title','slack')->first();
            $slack_secret->value  = $request->secret;
            $slack_secret->save();

            $slack_redirect =  Config::where('key','redirect_uri')->where('title','slack')->first();
            $slack_redirect->value  = $request->redirect_uri;
            $slack_redirect->save();

            if($request->channel)
            {
                $slack_channel =  Config::where('key','channel')->where('title','slack')->first();
                $slack_channel->value  = $request->channel;
                $slack_channel->save();
            }

            if($request->access_token)
            {
                $slack_access_token =  Config::where('key','access_token')->where('title','slack')->first();
                $slack_access_token->value  = $request->access_token;
                $slack_access_token->save();
            }
           //return view('crm::zoho.add',compact('zoho'))->with('status', 'saved');
           $arr['success'] = 'Slack credentials updated successfully';
            return json_encode($arr);
            exit;
    }

    function slackTokenRequest()
    {
        $slack_client_id =  Config::where('key','client_id')->where('title','slack')->first();
       
       /*$url =  SlackApi::get('oauth.authorize',['client_id'=>$slack_client_id,
                                    'redirect_uri'=>$slack_redirect]);
       dd($url);*/
        $url = 'https://slack.com/oauth/authorize?scope=incoming-webhook&client_id='.$slack_client_id->value.'&scope='.htmlentities('chat:write:user');

        $return['url'] = $url;

      // return Redirect::to($url);
        return json_encode($return);

    }

    function getToken(Request $request)
    {
       //dd($request->all()); 

         $slack_client_id =  Config::where('key','client_id')->where('title','slack')->first();
        $slack_secret =  Config::where('key','secret')->where('title','slack')->first();
        $slack_redirect =  Config::where('key','redirect_uri')->where('title','slack')->first();

        /*$url = "https://slack.com/api/oauth.access?client_id={$slack_client_id->value}&client_secret={$slack_secret->value}&code=$request->code";*/
        //dd($url);
        //echo $url;
       if($request->code)
       {
            $response = SlackApi::post('oauth.access',['client_secret'=>$slack_secret->value,'client_id'=>$slack_client_id->value,
                                    'code'=>$request->code]);
            /*if($response->ok)
            {
                $slack_access_token =  Config::where('key','access_token')->where('title','slack')->first();
                $slack_access_token->value  = $response->access_token;
                $slack_access_token->save();
            }*/
           echo 'Please copy the access token and paste in access token field and click the Update botton.<br/>';
           dd('access_token ==> '.$response->access_token);
            //return Redirect::to(URL::route('admin.setting.all'));

            //dd('Access token reset successfully.');
            
       }
    }
    
}
