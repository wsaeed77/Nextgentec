
<div class="no-gutter" id="networks">
  <div class="">
    <div class="no-padding dashtbl">
       <table class="table">
            <tbody id="loc_networks">
            @foreach($customer->locations as $location)
            @foreach($location->networks as $network)
            <tr id="nettr-{{$network->id}}" class="locnetHead trb">
                <td>
                    <span style="cursor:pointer;" id="expand-btn-{{$network->id}}" class="tbltoggle" data-id="{{$network->id}}"><i id="icn-{{$network->id}}" class="fa fa-plus-square-o" style="color: #969696; text-shadow: 1px 1px 1px #ccc; margin-right: 5px;"></i> {{$location->location_name}}</span>
                </td>
                <td id="nettd-{{$network->id}}" class="nettd">
                    <span id="netsn-{{$network->id}}">{{$network->lansubnet}}</span>
                </td>
            </tr>
            <tr>
              <td colspan="2" id="netdl-{{$network->id}}" style="border: none;display:none; padding-top: 0;">
                <span style="width:100%">
                    <table style="margin-top: 10px; width:100%">
                    <tr class="netTbl bs-callout bs-callout-grey bs-callout-white-fill" >
                        <td style="width: 55%;" valign="top"><i id="icn-{{$network->id}}" class="fa fa-cloud" style="color: #969696; text-shadow: 1px 1px 1px #ccc; margin-right: 5px;"></i> Lan</td>
                        <td>
                            <dl class="dlhorizon clearfix no-margin">
                                <dt>Subnet</dt>
                                <dd>{{$network->lansubnet}}</dd>
                                <dt>Subnetmask</dt>
                                <dd>{{$network->lansubnetmask}}</dd>
                            </dl>
                        </td>
                    </tr>
                    <tr class="spacer"></tr>
                    <tr class="netTbl bs-callout bs-callout-danger bs-callout-white-fill">
                        <td valign="top"><i id="icn-{{$network->id}}" class="fa fa-globe" style="color: #969696; text-shadow: 1px 1px 1px #ccc; margin-right: 6px;"></i> Wan</td>
                        <td>
                            <dl class="dlhorizon clearfix no-margin">
                                <dt>Public IP</dt>
                                <dd>{{$network->wanip}}</dd>
                                <dt>Gateway</dt>
                                <dd>{{$network->wangw}}</dd>
                                <dt>Subnetmask</dt>
                                <dd>{{$network->wansubnetmask}}</dd>
                                <dt>DNS</dt>
                                <dd>{{$network->dns1}}<br />{{$network->dns2}}</dd>
                            </dl>
                        </td>
                    </tr>
                    </table>
                </span>
              </td>
            </tr>
            @endforeach
            @endforeach

          </tbody></table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>
