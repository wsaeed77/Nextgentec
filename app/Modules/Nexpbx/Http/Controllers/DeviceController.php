<?php
namespace App\Modules\Nexpbx\Http\Controllers;

//use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;

use App\Modules\Nexpbx\Http\Device;
use App\Modules\Nexpbx\Http\Domain;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerLocation;
use App\Model\Config;
// use App\Model\Role;
// use App\Model\User;
// use Auth;
// use URL;
use Datatables;

use Session;
class DeviceController extends Controller
{
  function index() {

    $customers=Customer::where('is_active', 1)
    ->orderBy('name', 'desc')
    ->get();
    $enabled_customers=[];
    foreach ($customers as $cus) {
     $enabled_customers[$cus['id']]=$cus['name'];

   }
   $current_customer_locations=[];
   return view('nexpbx::devices.index',compact('enabled_customers','current_customer_locations'));
 }

  // Datatables Device list
 function dt_devices() {

  $domains = Domain::with(['customer'])->where('customer_id',0);


  $date_format = Config::where('title','date_format')->first();

  return Datatables::of($domains)
  // ->editColumn('device_template', function ($device) {
  //   $array = explode("/", $device->device_template);
  //   return ucfirst($array[0]).' '.strtoupper($array[1]);
  // })

  ->setRowId('id')
  ->make(true);

    //return view('nexpbx::devices.index');
}


function ajaxLocationsJson($customer_id)
{


  $data['locations'] = CustomerLocation::where('customer_id',$customer_id)
      // ->whereNotIn('id', function($query) use($vendor_id){
      //   $query->select('location_id')
      //   ->from(with(new VendorCustomer)->getTable())
      //   ->where('vendor_id', $vendor_id);
      // })
  ->get();

  return json_encode($data);
  exit;
}

function ajaxCustomersJson($value='')
{
 $customers=Customer::where('is_active', 1)
 ->orderBy('name', 'desc')
 ->get();
 $enabled_customers=[];
 foreach ($customers as $cus) {
   $enabled_customers[$cus['id']]=$cus['name'];

 }
 return json_encode($enabled_customers);
 exit;
}

function assignCustomer(Request $request)
{

  $domains=explode(',',$request->selected_domains);

  foreach ($domains as $id) {


    $domain= Domain::find($id);

    $domain->customer_id=$request->assigning_custumers;
    $domain->location_id=$request->cust_location;
    $domain->save();
  }

  $arr['success'] = 'yes';
  $request->session()->flash('status', 'Domains successfully assigned to Customer!');

  return json_encode($arr);
  //$device= Device::find();
}

function assign_devices(){

 $current_customer_locations = CustomerLocation::where('customer_id',Session::get('cust_id'))
      // ->whereNotIn('id', function($query) use($vendor_id){
      //   $query->select('location_id')
      //   ->from(with(new VendorCustomer)->getTable())
      //   ->where('vendor_id', $vendor_id);
      // })
 ->get();

 $locations=[];
 foreach ($current_customer_locations as $loc) {
   $locations[$loc['id']]=$loc['location_name'];
 }

 $devices = Domain::with(['customer'])->where('customer_id',0)->get();


 return view('nexpbx::assign_devices',compact('locations','devices'));
}

function remove_device(Request $request){

  if($request->id){
    $domain= Domain::find($request->id);
    $domain->customer_id=0;
    $domain->save();
    $arr['success'] = 'yes';

  }else{
    $arr['success'] = false;
  }
  return json_encode($arr);
}

function change_type($id,$value){
  if($id){
    $device= Device::find($id);
    $device->device_type=$value;
    $device->save();
    $arr['success'] = 'yes';

  }else{
    $arr['success'] = false;
  }
  return json_encode($arr);

}

function change_location($id,$value){
  if($id){
    $device= Device::find($id);
    $device->location_id=$value;
    $device->save();
    $arr['success'] = 'yes';

  }else{
    $arr['success'] = false;
  }
  return json_encode($arr);

}



function nexpbxDevices(Request $request)
{

 return view('nexpbx::customer_devices');

}

function ajaxCustomerNexpbx()
{
     // $customers_obj = Device::with(['customer'])->where('customer_id',Session::get('cust_id'))->get();

 $global_date = $this->global_date;

 if(!empty(Session::get('cust_id')))
 {

  $devices = Domain::with(['customer','devices'])->where('customer_id',Session::get('cust_id'))->get();

}

return Datatables::of($devices)

->addColumn('location', function ($device) {
  $location = CustomerLocation::find($device->location_id);

  if($location)
    return  $location->location_name;
  else
    return '------';
})

->editColumn('created_at', function ($device) use ($global_date){
  return  date($global_date,strtotime($device->created_at));
})

->editColumn('device_type', function ($device){
  $return= '<select>';

  if(is_null($device->device_type)){
    $return .= '<option selected value="">Select type</option>';
  }else{
    if($device->device_type=='BYOD'){

    }
    $return .= '<option selected value="">Select type</option>';return $device->device_type;
  }
  $return='<option value="BYOD">BYOD</option>';
  $return='<option value="Leased">Leased</option>';
  $return .= '</select>';
  return $return;

})

->addColumn('action', function ($device) {
  if(!empty(Session::get('cust_id')))
  {
    $return = '<div class="btn-group">';

    $return .=' <button type="button" class="btn btn-danger btn-xs"
    data-toggle="modal" data-id="'.$device->id.'" id="modaal" data-target="#modal_device_remove">
    <i class="fa fa-times-circle"></i></button></div>';
    $return .= '</div>';


    $return .= '</div>';

    return $return;
  }
})


->setRowId('id')
->make(true);

}

function DomainDevices($id){
  $domain = Domain::where('domain_uuid',$id)->first();

  $domain_name = $domain->domain_name;
  return view('nexpbx::customer_domain_devices',compact('id','domain_name'));
}

function ajaxCustomerDevices($domain_uuid){
    // $customers_obj = Device::with(['customer'])->where('customer_id',Session::get('cust_id'))->get();
    $global_date = $this->global_date;

   if(!empty(Session::get('cust_id')))
   {
     $devices = Device::with(['domain'])->where('domain_uuid',$domain_uuid) ->get();
   }

   return Datatables::of($devices)

->addColumn('location', function ($device) {
  $locations = CustomerLocation::where('customer_id',Session::get('cust_id'))->get();

  $return = '<select class="form-control input-sm" onchange="change_location('.$device->id.',this.value)">';
  $return .= '<option  value="">Select Location</option>';
  foreach ($locations as $key => $location) {
    $selected=($device->Location_id==$location->id)?"selected":"";
    $return .='<option '.$selected.'  value="'.$location->id.'">'.$location->location_name.'</option>';

  }
  $return .= '</select>';
  return $return;
})

->editColumn('created_at', function ($device) use ($global_date){
  return  date($global_date,strtotime($device->created_at));
})

->editColumn('device_vendor', function ($device) {
  return  ucfirst($device->device_vendor);
})

->editColumn('device_type', function ($device){
  $return= '<select class="form-control input-sm" onchange="change_type('.$device->id.',this.value)">';

  if(is_null($device->device_type)){
    $return .= '<option selected value="">Select type</option>';
    $return .='<option  value="BYOD">BYOD</option>';
    $return .='<option  value="Leased">Leased</option>';
  }else{

    $return .= '<option  value="">Select type</option>';
    if($device->device_type=='BYOD'){
      $return .='<option selected value="BYOD">BYOD</option>';
      $return .='<option  value="Leased">Leased</option>';
    }else if($device->device_type=='Leased'){
      $return .='<option  value="BYOD">BYOD</option>';
      $return .='<option selected value="Leased">Leased</option>';
    }

  }
  $return .= '</select>';
  return $return;

})


->addColumn('action', function ($device) {
  if(!empty(Session::get('cust_id')))
  {
    $return = '<div class="btn-group">';

    $return .=' <button type="button" class="btn btn-danger btn-xs"
    data-toggle="modal" data-id="'.$device->id.'" id="modaal" data-target="#modal_device_remove">
    <i class="fa fa-times-circle"></i></button></div>';
    $return .= '</div>';


    $return .= '</div>';

    return $return;
  }
})


->setRowId('id')
->make(true);
}

function device_detail($id){
  $device = Device::where('id',$id)->first();
  $model = strtoupper(explode('/', $device->device_template)[1]);

  return view('nexpbx::devices.detail_partial',compact('device','model'));
}

function updateNotes(Request $request){

  $device=Device::find($request->device_id);
  $device->notes=$request->device_notes;
  if($device->save()){
    $arr['success'] = 'yes';
  }else{
    $arr['success'] = false;
  }

  return json_encode($arr);

}

}
