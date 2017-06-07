<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\GoogleGmail;
use App\Model\Config;
use App\Modules\Employee\Http\Employee;
use App\Model\User;
use App\Model\UserDevice;
use App\Services\TimeZone;

// Used By crmBilling function
use App\Modules\Crm\Http\DefaultRate;
use App\Modules\Crm\Http\CustomerBillingPeriod;
use App\Modules\Crm\Http\CustomerServiceType;

use App\Modules\Assets\Http\AssetRole;
use App\Modules\Assets\Http\AssetVirtualType;
use Datatables;
use Auth;
use Cookie;

class SettingController extends Controller
{
    /*
      Billing CRM Settings
     */
      public function defaultRates(Request $request) {
      //$request->session()->put('panel', 'admin');

        $defaultRates = DefaultRate::all();
        return view('crm::settings.defaultrates.index',compact('defaultRates'))->render();
      }

      public function createDefaultRate(Request $request) {
      //$request->session()->put('panel', 'admin');

        $this->validate($request,[
          'title' => 'required',
          'amount' => 'required',
          ]);
        $rate = new DefaultRate;
        $rate->title = $request->title;
        $rate->amount = $request->amount;
        $rate->save();

        $arr['success'] = 'Rate created successfully';
        return json_encode($arr);
        exit;
      }

      public function deleteDefaultRate(Request $request) {
      //$request->session()->put('panel', 'admin');

        $rate = DefaultRate::find($request->id);
        $rate->delete();
        $arr['success'] = 'Rate deleted successfully';
        return json_encode($arr);
        exit;
      }

      public function billingPeriods(Request $request) {
      //$request->session()->put('panel', 'admin');

        $billingPeriods = CustomerBillingPeriod::all();
        return view('crm::settings.billingperiods.index',compact('billingPeriods'))->render();
      }

      public function deleteBillingPeriod(Request $request) {
        $request->session()->put('panel', 'admin');

        $id = $request->id;
        $billing_period = CustomerBillingPeriod::findorFail($id);
        $billing_period->delete();
        $arr['success'] = 'Billing period deleted successfully';
        return json_encode($arr);
        exit;
      }

      public function createBillingPeriod(Request $request) {
      //$request->session()->put('panel', 'admin');

        $this->validate($request, [
          'title' => 'required|unique:customer_billing_periods|max:15',
          'description' => 'required',
          ]);

        $billing_period = New CustomerBillingPeriod();
        $billing_period->title = $request->title;
        $billing_period->description = $request->description;
        $billing_period->save();

        $arr['success'] = 'Billing period created successfully';
        return json_encode($arr);
        exit;
      }

      public function serviceTypes(Request $request) {
      //$request->session()->put('panel', 'admin');

        $serviceItems = CustomerServiceType::all();
        return view('crm::settings.servicetypes.index',compact('serviceItems'))->render();
      }

      public function deleteServiceType(Request $request) {
      //$request->session()->put('panel', 'admin');

        $service_item = CustomerServiceType::findorFail($request->id);
        $service_item->delete();

        $arr['success'] = 'Service item deleted successfully';
        return $arr;
      }

      public function createServiceType(Request $request) {
        $this->validate($request, [
         'title' => 'required|unique:customer_service_types|max:15',
         'description' => 'required|max:15',
         ]);

        $service_item = New CustomerServiceType();
        $service_item->title = $request->title;
        $service_item->description = $request->description;
        $service_item->save();
        $arr['success'] = 'Service item added successfully';

        return $arr;
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index(Request $request)
    {
     $request->session()->put('panel', 'admin');
     $user = \Auth::user();
      //  $timezone = new TimeZone();
      //  $time_zones = $timezone->timezone_list();
       //
      //  $request->session()->put('panel', 'admin');

     return view('crm::settings.index',compact('user'));

   }

   function permissions(Request $request)
   {
      //$request->session()->put('panel', 'admin');

     $user = \Auth::user();
     //$request->session()->put('panel', 'admin');

     return view('admin.setting.permissions',compact('user'));

   }

   public function imap()
   {
    $imap = Config::where('title','imap')->get();
        //dd($imap);
    $imap_email ='';
    $imap_password = '';
    foreach ($imap as $value) {
      if($value->key=='email')
        $imap_email = $value->value;
      if($value->key=='password')
        $imap_password = $value->value;
    }
        //dd($imap_email);
        //return view('admin.config.imap',compact('imap_email','imap_password'));
    $arr['imap_email'] = $imap_email;
    $arr['imap_password'] = $imap_password;
    return $arr;
  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imapStore(Request $request)
    {
     $this->validate($request,
      [
      'gmail_email' => 'required',
      'gmail_password'=>'required',


      ]);


     $imap =  Config::where('key','email')->where('title','imap')->first();
     $imap->value  = $request->gmail_email;
     $imap->save();

     $imap =  Config::where('key','password')->where('title','imap')->first();
     $imap->value  = $request->gmail_password;
     $imap->save();


     $arr['success'] = 'IMAP credentials updated successfully';
       //$arr['imap_password'] = $imap_password;
     return $arr;

         //return redirect()->intended('admin/config/imap')->with('success', 'Gmail credentials updated Successfully!');
   }

   public function smtp()
   {
    $smtp_arr = Config::where('title','smtp')->get();

    $arr =[];
    foreach ($smtp_arr as $value) {
      if($value->key=='server_address')
        $arr['server_address'] = $value->value;
      if($value->key=='gmail_address')
        $arr['gmail_address'] = $value->value;
      if($value->key=='gmail_password')
        $arr['password'] = $value->value;
      if($value->key=='port')
        $arr['port'] = $value->value;
    }


    $imap = Config::where('title','imap')->get();
        //dd($imap);
    $imap_email ='';
    $imap_password = '';
    foreach ($imap as $value) {
      if($value->key=='email')
        $imap_email = $value->value;
      if($value->key=='password')
        $imap_password = $value->value;
    }
        //dd($imap_email);
        //return view('admin.config.imap',compact('imap_email','imap_password'));
    $arr['imap_email'] = $imap_email;
    $arr['imap_password'] = $imap_password;
    
        //dd($imap_email);
       // return view('admin.config.smtp',compact('smtp'));


    return $arr;
  }

  public function googleAuth()
  {
    $google_auth_arr = Config::where('title','google_auth')->get();

    $google_auth =[];
    foreach ($google_auth_arr as $value) {
      if($value->key=='gmail_auth_client_id')
        $google_auth['gmail_auth_client_id'] = $value->value;
      if($value->key=='gmail_auth_client_secret')
        $google_auth['gmail_auth_client_secret'] = $value->value;
      if($value->key=='redirect_uri')
        $google_auth['redirect_uri'] = $value->value;

    }
        //dd($imap_email);
       // return view('admin.config.smtp',compact('smtp'));

//dd($google_auth);
    return $google_auth;
  }

  public function smtpStore(Request $request)
  {


        //dd($request->all());
    $this->validate($request,
      [
      'gmail_email' => 'required',
      'gmail_password'=>'required',
      'server_address' => 'required',
      'smtp_address'=>'required',
      'smtp_password' => 'required',
      'smtp_port'=>'required',



      ]);


    $smtp =  Config::where('key','server_address')->where('title','smtp')->first();
    $smtp->value  = $request->server_address;
    $smtp->save();

    $smtp =  Config::where('key','gmail_address')->where('title','smtp')->first();
    $smtp->value  = $request->smtp_address;
    $smtp->save();

    $smtp =  Config::where('key','gmail_password')->where('title','smtp')->first();
    $smtp->value  = $request->smtp_password;
    $smtp->save();

    $smtp =  Config::where('key','port')->where('title','smtp')->first();
    $smtp->value  = $request->smtp_port;
    $smtp->save();

    $imap =  Config::where('key','email')->where('title','imap')->first();
    $imap->value  = $request->gmail_email;
    $imap->save();

    $imap =  Config::where('key','password')->where('title','imap')->first();
    $imap->value  = $request->gmail_password;
    $imap->save();


    $arr['success'] = 'IMAP and SMTP credentials updated successfully';
       //$arr['imap_password'] = $imap_password;
       //$arr['imap_password'] = $imap_password;
    return $arr;

        // return redirect()->intended('admin/config/smtp')->with('success', 'SMTP Gmail credentials updated Successfully!');
  }

  function updateEmailData(Request $request)
  {
        //dd($request->all());

    $employee = User::find(Auth::user()->id);

    $employee->email_template = $request->email_template;
    $employee->save();
       // if()

       /* $intro_email = Config::where('title','intro_email')->first();
        $intro_email->value = $request->intro;

        $intro_email->save();
*/
        $arr['success'] = 'Email template updated successfully';
        return json_encode($arr);
        exit;
      }



      function updateEmailSignature(Request $request)
      {
        //dd($request->all());

        $employee = User::find(Auth::user()->id);

        $employee->email_signature = $request->email_signature;
        $employee->save();
       // if()



        $arr['success'] = 'Email signature updated successfully.';
        return json_encode($arr);
        exit;
      }


      public function zohoSettingsDisplay()
      {
        $zoho = Config::where('title','zoho')->get();

        foreach ($zoho as $value) {
         if($value->key=='email')
          $zoho_arr['email'] = $value->value;
        if($value->key=='password')
          $zoho_arr['password'] = $value->value;
        if($value->key=='auth_token')
          $zoho_arr['auth_token'] = $value->value;

      }


         //return view('crm::zoho.add',compact('zoho_arr'))->render();

      return view('crm::settings.integrations.zoho_display',compact('zoho_arr'));
      
    }

    function zohoStore(Request $request)
    {
      //dd($request->all());
        //$id = $request->zoho_id;
      $this->validate($request,
        [
        'email' => 'required',
        'password' => 'required',


        ]);

        //dd($request->all());
      $zoho_email =  Config::where('key','email')->where('title','zoho')->first();
      $zoho_email->value  = $request->email;
      $zoho_email->save();

      $zoho_pass =  Config::where('key','password')->where('title','zoho')->first();
      $zoho_pass->value  = $request->password;
      $zoho_pass->save();

      $zoho_token =  Config::where('key','auth_token')->where('title','zoho')->first();
      $zoho_token->value  = $request->token;
      $zoho_token->save();


      $arr['success'] = 'Zoho credentials updated successfully';
      return json_encode($arr);
      exit;
    }

    function telFaxUpdate(Request $request)
    {
     $tel =  Config::where('key','telephone')->first();
     $mob =  Config::where('key','mobile')->first();
     $fax =  Config::where('key','fax')->first();


     if($tel)
     {
      $tel->value= $request->telephone;
      $tel->save();
    }
    else
    {
      $tel = new Config;
      $tel->title = 'telephone_number';
      $tel->value = $request->telephone;
      $tel->key = 'telephone';
      $tel->save();
    }

    if($mob)
    {
      $mob->value= $request->mobile;
      $mob->save();
    }
    else
    {
      $mob = new Config;
      $mob->title = 'mobile_number';
      $mob->value = $request->mobile;
      $mob->key = 'mobile';
      $mob->save();
    }

    if($fax)
    {
      $fax->value= $request->fax;
      $fax->save();
    }
    else
    {
      $fax = new Config;
      $fax->title = 'fax_number';
      $fax->value = $request->fax;
      $fax->key = 'fax';
      $fax->save();
    }

    $arr['success'] = 'Tel/Mobile/Fax numbers updated successfully';
    return json_encode($arr);
    exit;

  }  


  function updateDateTime(Request $request)
  {
        //dd($request->all());

    if($request->date_format)
    {
      $date = Config::where('title','date_format')->first();
      if($date)
      {
                //dd('jj');
        $date_format_arr = explode('|',$request->date_format);
        $date_format_key = $date_format_arr[1];
        $date_format_value = $date_format_arr[0];
        $date->key =  $date_format_key ;
        $date->value = $date_format_value ;
        $date->save();
      }
      else
      {
       $date_format_arr = explode('|',$request->date_format);
       $date_format_key = $date_format_arr[1];
       $date_format_value = $date_format_arr[0];

       $date = new Config;
       $date->title = 'date_format';
       $date->value = $date_format_value;
       $date->key  = $date_format_key;
       $date->save();
     }
   }

   if($request->time_format)
   {
    $time = Config::where('title','time_format')->first();
    if($time)
    {
      $time->value = $request->time_format;
      $time->save();
    }
    else
    {
      $time = new Config;
      $time->title = 'time_format';
      $time->value = $request->time_format;
      $time->key = 'time_format';
      $time->save();
    }
  }

        //$intro_email->save();

  $arr['success'] = 'Date/Time format updated successfully';
  return json_encode($arr);
  exit;
}

public function getDateTime()
{
  $date = Config::where('title','date_format')->first();
  $time = Config::where('title','time_format')->first();


  $arr['config_date'] = $date->value.'|'.$date->key;
  $arr['config_time'] = $time->value;

  return json_encode($arr);
  exit;    
}



public function slackSettingsDisplay()
{
  $slack = Config::where('title','slack')->get();

  foreach ($slack as $value) {
   if($value->key=='client_id')
    $slack_arr['client_id'] = $value->value;
  if($value->key=='secret')
    $slack_arr['secret'] = $value->value;
  if($value->key=='channel')
    $slack_arr['channel'] = $value->value;
  if($value->key=='redirect_uri')
    $slack_arr['redirect_uri'] = $value->value;
  if($value->key=='access_token')
    $slack_arr['access_token'] = $value->value;

}

         //return view('crm::zoho.add',compact('zoho_arr'))->render();

return view('crm::settings.integrations.slack_display',compact('slack_arr'));

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


  $url = 'https://slack.com/oauth/authorize?scope=incoming-webhook&client_id='.$slack_client_id->value.'&scope='.htmlentities('chat:write:user');

  $return['url'] = $url;


  return json_encode($return);
}


public function gmailSettingsDisplay()
{

  $smtp_arr = Config::where('title','smtp')->get();

  $smtp =[];
  foreach ($smtp_arr as $value) {
    if($value->key=='server_address')
      $gmail['server_address'] = $value->value;
    if($value->key=='gmail_address')
      $gmail['gmail_address'] = $value->value;
    if($value->key=='gmail_password')
      $gmail['password'] = $value->value;
    if($value->key=='port')
      $gmail['port'] = $value->value;
  }


  $imap = Config::where('title','imap')->get();
        //dd($imap);
  $imap_email ='';
  $imap_password = '';
  foreach ($imap as $value) {
    if($value->key=='email')
      $imap_email = $value->value;
    if($value->key=='password')
      $imap_password = $value->value;
  }
        //dd($imap_email);
        //return view('admin.config.imap',compact('imap_email','imap_password'));
  $gmail['imap_email'] = $imap_email;
  $gmail['imap_password'] = $imap_password;



  $google_auth_arr = Config::where('title','google_auth')->get();

  $google_auth =[];
  foreach ($google_auth_arr as $value) {
    if($value->key=='gmail_auth_client_id')
      $gmail['gmail_auth_client_id'] = $value->value;
    if($value->key=='gmail_auth_client_secret')
      $gmail['gmail_auth_client_secret'] = $value->value;
    if($value->key=='redirect_uri')
      $gmail['redirect_uri'] = $value->value;

  }  

         //return view('crm::zoho.add',compact('zoho_arr'))->render();

  return view('crm::settings.integrations.gmail_display',compact('gmail'));

}




function resetAuthToken()
{

        //dd($id);
  $zoho_email = Config::where('title','zoho')->where('key','email')->first();
  $zoho_pass = Config::where('title','zoho')->where('key','password')->first();
        //dd($zoho_email);
  $url  = 'https://accounts.zoho.com/apiauthtoken/nb/create?SCOPE=ZohoInvoice/invoiceapi&EMAIL_ID='.$zoho_email->value.'&PASSWORD='.$zoho_pass->value;

  $curl = curl_init($url);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $result = curl_exec($curl);
       // dd($result);

  $arr['msg'] = $result;
  return json_encode($arr);
  exit;

}


function assetServerRoleSettingsDisplay(){


 return view('crm::settings.assets.asset_server_role_display');
}


function listServerRoles()
{
  $global_date = $this->global_date;
  $roles = AssetRole::all();
      //dd($roles);

  return Datatables::of($roles)


  ->addColumn('action', function ($role) {

    $return = '<div class="btn-group"><button type="button" class="btn btn-danger btn-xs"
    data-toggle="modal" data-id="'.$role->id.'" id="modaal" data-target="#modal-delete-asset-server-role">
    <i class="fa fa-times-circle"></i>
  </button></div>';



  return $return;
})
  ->editColumn('created_at', function ($role) use ($global_date){

    return  date($global_date,strtotime($role->created_at));
  })
  ->make(true);

}


function destroyServerRole(Request $request)
{
  $role = AssetRole::find($request->id);
  $role->delete();

  $arr['success'] = 'Server role deleted sussessfully';
  return json_encode($arr);
  exit;
      //return true;

}


function createServerRole(Request $request)
{

  $this->validate($request,
   [
   'title' => 'required|unique:asset_roles',

   ]);

      //$role = AssetRole::where('title',$role)->get();

  $new_role = new AssetRole();
  $new_role->title = $request->title;
  $new_role->save();

  $arr['success'] = 'Server role added sussessfully';
  return json_encode($arr);
  exit;

}




function listServerVirtualTypes()
{
  $global_date = $this->global_date;
  $vtypes = AssetVirtualType::all();
      //dd($roles);

  return Datatables::of($vtypes)


  ->addColumn('action', function ($vtype) {

    $return = '<div class="btn-group"><button type="button" class="btn btn-danger btn-xs"
    data-toggle="modal" data-id="'.$vtype->id.'" id="modaal" data-target="#modal-delete-asset-server-v-type">
    <i class="fa fa-times-circle"></i>
  </button></div>';



  return $return;
})
  ->editColumn('created_at', function ($vtype) use ($global_date){

    return  date($global_date,strtotime($vtype->created_at));
  })
  ->make(true);

}
function destroyServerVirtualType(Request $request)
{
  $vtype = AssetVirtualType::find($request->id);
  $vtype->delete();

  $arr['success'] = 'Server virtual type deleted sussessfully';
  return json_encode($arr);
  exit;
      //return true;

}

function createServerVirtualType(Request $request)
{

  $this->validate($request,
   [
   'title' => 'required|unique:asset_virtual_types',

   ]);

      //$role = AssetRole::where('title',$role)->get();

  $vtype = new AssetVirtualType();
  $vtype->title = $request->title;
  $vtype->save();

  $arr['success'] = 'Server virtual type added sussessfully';
  return json_encode($arr);
  exit;

}


function system(Request $request) {
      //$request->session()->put('panel', 'admin');
  $user = \Auth::user();
  $timezone = new TimeZone();
  $time_zones = $timezone->timezone_list();

  $sys_date_fmt = Config::where('title','date_format')->first();
  $sys_time_fmt = Config::where('title','time_format')->first();

      //$request->session()->put('panel', 'admin');
  return view('admin.setting.system',compact('user','time_zones','sys_date_fmt','sys_time_fmt'));
}

function assetServerVTypesSettingsDisplay(){

 return view('crm::settings.assets.asset_server_v_types_display');
}

function systemSave(Request $request) {
      // Save the date format
  $date_format_arr = explode('|',$request->date_format);
  $date_format_key = $date_format_arr[1];
  $date_format_value = $date_format_arr[0];
  if(!$this->saveConfigSetting('date_format',$date_format_key,$date_format_value))
    return json_encode(['result' => 'fail']);

      // Save the time format
  if(!$result = $this->saveConfigSetting('time_format','',$request->time_format))
    return json_encode(['result' => 'fail']);

      // Save the time zone format
  if(!$this->saveConfigSetting('system_timezone','timezone',$request->time_zone))
    return json_encode(['result' => 'fail']);

      // Save the telephone format
  if(!$this->saveConfigSetting('telephone_number','telephone',$request->telephone))
    return json_encode(['result' => 'fail']);

  return json_encode(['result' => 'success']);
}

private function saveConfigSetting($title, $key, $value) {
  $config = Config::where('title',$title)->first();

      // Let's create the setting if it does not exist already
  if(!$config) {
    $config = new Config;
    $config->title = $title;
  }

  $config->key = $key;
  $config->value = $value;
  return $config->save();
}


function getEmailData()
{

  $employee = User::find(Auth::user()->id);


  $arr['email_template'] = $employee->email_template;






  return json_encode($arr);
  exit;
}


function getUserDevices()
{

  $devices = UserDevice::where('user_id',Auth::user()->id)->get();

  return json_encode($devices);
  exit;
}

function deleteUserDevice($id){

  $device = UserDevice::find($id);
  if($device->cookie_id==Cookie::get('nexgen_device')){
    Cookie::forget('nexgen_device');
  }
  
  $device->delete();

  $arr['success'] = 'Device extention deleted successfully';
  return json_encode($arr);
  exit;
}

function getEmailSignature()
{

  $employee = User::find(Auth::user()->id);


  $arr['email_signature'] = $employee->email_signature;

  return json_encode($arr);
  exit;
}

function gmailApiUpdate(Request $request)
{

 $this->validate($request,
  [
  'gmail_auth_client_id' => 'required',
  'gmail_auth_client_secret'=>'required',
  'redirect_uri'=>'required',
  ]);


 $auth_key =  Config::where('key','gmail_auth_client_id')->first();
 $auth_key->value  = $request->gmail_auth_client_id;
 $auth_key->save();

 $auth_secret =  Config::where('key','gmail_auth_client_secret')->first();
 $auth_secret->value  = $request->gmail_auth_client_secret;
 $auth_secret->save();

 $redirect_uri =  Config::where('key','redirect_uri')->first();
 $redirect_uri->value  = $request->redirect_uri;
 $redirect_uri->save();
        //$gmail = new GoogleGmail('new');
            /*$file_path              = base_path('resources/assets');
            $file['client_id']      = $request->gmail_auth_client_id;
            $file['client_secret']  = $request->gmail_auth_client_secret;
           //$file['redirect_uris']  = [\URL::route('get_token')];
            $file['redirect_uris']  = ['http://crm.ng2.us/get_token'];
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

*/
               $gmail = new GoogleGmail('reset');

            //dd($gmail->auth_url);
               return compact("gmail");

           // dd('done');

             }

             function getToken(Request $request)
             {
              $code = $request->all();
        //dd($request->all());

              $token = $code['code'].'#';

              $set = new GoogleGmail('token_reset',$token);
              if($set)
                dd('credentials updated successfully');
        //dd( $token);

            }




          }
