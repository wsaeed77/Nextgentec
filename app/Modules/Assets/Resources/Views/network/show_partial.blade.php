<div class="col-lg-6">
  <h4 style="margin-top: 0;">{{$network->location->customer->name}}</h4>
</div>

<div class="col-lg-6 text-right">
  @if($network->location)
    {{$network->location->location_name}}
  @endif
</div>

<div class="col-lg-12">
  <div class="box-body no-padding">
    <table class="table table-condensed">
      <tbody>
      <tr>
        <td style="padding-top: 20px;"><b>LAN</b><br>
          <span style="padding-left: 15px;">Subnet</span><br>
          <span style="padding-left: 15px;">Subnetmask</span><br>
          <span style="padding-left: 15px;">Gateway</span>
        </td>
        <td><br><br>{{$network->lansubnet}}<br>{{$network->lansubnetmask}}<br>{{$network->langw}}
        </td>
      </tr>
      <tr>
        <td><b>WAN</b><br>
          <span style="padding-left: 15px;">IP Address</span><br>
          <span style="padding-left: 15px;">Subnetmask</span><br>
          <span style="padding-left: 15px;">Gateway</span><br>
          <span style="padding-left: 15px;">Primary DNS</span><br>
          <span style="padding-left: 15px;">Secondary DNS</span>
        </td>
        <td><br>{{$network->wanip}}<br>{{$network->wansubnetmask}}<br>{{$network->wangw}}<br>{{$network->dns1}}<br>{{$network->dns2}}
        </td>
      </tr>
    </tbody></table>
  </div>

<h5 style="padding-top: 20px;">Notes</h5>
<textarea class="form-control" rows="4">{{$network->notes}}</textarea>
</div>
<div class="clearfix"></div>
