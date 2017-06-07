<div style="margin-bottom: 15px;">{{$vendor->name}}<span class="pull-right">{{$vendor->phone_number}}</span></div>

<div class="panel panel-default">
  <div class="panel-heading">Account info</div>
  <table class="table">
    <tr>
      <td class="width35">Billing Contact</td>
      <td>{{$vendor->customers[0]->name}}</td>
    </tr>
    <tr>
      <td>Billing Phone Number</td>
      <td>{{$vendor->customers[0]->pivot->phone_number}}</td>
    </tr>
    <tr>
      <td>Billing Address</td>
      @if(!empty($location))
      <td>{{$location->address}}<br />{{$location->city}}, {{$location->state}} {{$location->zip}}</td>
      @else
      <td></td>
      @endif
    </tr>
    <tr>
      <td>Account Number</td>
      <td>{{$vendor->customers[0]->pivot->account_number}}</td>
    </tr>
  </table>
</div>
@if($location)
<div class="panel panel-default">
  <div class="panel-heading">Location</div>
  <table class="table">
    <tr>
      <td class="width35">Title</td>
      <td>{{$location->location_name}}</td>
    </tr>
    <tr>
      <td>Address</td>
      <td>{{$vendor->address}}<br />{{$vendor->city}},{{$vendor->city}}, {{$vendor->state}} {{$vendor->zip}}</td>
    </tr>
   
   
  </table>
</div>
@endif
<div class="panel panel-default">
  <div class="panel-heading">Vendor Portal</div>
  <table class="table">
    <tr>
      <td class="width35">URL</td>
      <td>{{$vendor->customers[0]->pivot->portal_url}}</td>
    </tr>
    <tr>
      <td>Username</td>
      <td>@if($vendor->password){{$vendor->password->login}}@endif</td>
    </tr>
    <tr>
      <td>Password</td>
      <td>@if($vendor->password){{$vendor->password->password}}@endif</td>
    </tr>
  </table>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Vendor General</div>
  <table class="table" style="table-layout:fixed">
    <tr>
      <td class="width35">Dialing Instructions</td>
      <td> {!! html_entity_decode($vendor->dailing_instructions) !!}</td>
    </tr>
    <tr>
      <td>Website</td>
      <td class="hideOverflow"><a href="{{$vendor->website}}" target="_blank">{{$vendor->website}}</a></td>
    </tr>
    <tr>
      <td>Address</td>
      @if(!empty($vendor->address))
      <td>{{$vendor->address}}<br />{{$vendor->city}}, {{$vendor->state}} {{$vendor->zip}}</td>
      @else
      <td></td>
      @endif
    </tr>
  </table>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    Notes
  </div>
  <div class="panel-body">
    <pre>{{$vendor_customer->notes}}</pre>
  </div>
</div>

<style>
.hideOverflow
{
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
    width:100%;
    display:block;
}

.width35 {
  width: 35%;
}
</style>
