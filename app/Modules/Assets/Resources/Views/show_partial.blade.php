<div class="col-lg-12">
  <h4 style="margin-top: 0;">{{$asset->customer->name}}</h4>
  <h5>
  @if($asset->location)
    {{$asset->location->location_name}}
  @endif
  </h5>
</div>

@if($asset->asset_type=='network')
<div class="col-lg-12">
  <div class="box-body no-padding">
    <table class="table table-condensed">
      <tbody>
      <tr>
        <td style="padding-top: 20px;"><b>Device</b><br>
          <span style="padding-left: 15px;">Type</span><br>
          <span style="padding-left: 15px;">Operating System</span><br>
          <span style="padding-left: 15px;">Manufacture</span><br>
          <span style="padding-left: 15px;">Model</span>
        </td>
        <td><br><br>{{ucfirst($asset->asset_type)}}<br>{{$asset->os}}<br>{{$asset->manufacture}}<br>
          {{$asset->model}}
        </td>
      </tr>
      <tr>
        <td><b>Credentials</b><br>
          <span style="padding-left: 15px;">User Name</span><br>
          <span style="padding-left: 15px;">Password</span>
        </td>
        <td><br><?php if ($asset->password) :
?>{{$asset->password->login}}<br>{{$asset->password->password}}<?php
                endif;?>
        </td>
      </tr>
      <tr>
        <td><b>Network</b><br>
          <span style="padding-left: 15px;">IP Address</span><br>
          <span style="padding-left: 15px;">IP Type</span>
        </td>
        <td><br>{{$asset->ip_address}}<br>
          @if($asset->is_static==0)
            <span class="badge bg-yellow">DHCP</span>
          @elseif($asset->is_static==1)
            <span class="badge bg-green">Static</span>
          @endif
        </td>
    </tr>
    </tbody></table>
  </div>

<h5 style="padding-top: 20px;">Notes</h5>
<textarea class="form-control" rows="4">{{$asset->notes}}</textarea>
</div>
<div class="clearfix"></div>

@endif

@if($asset->asset_type=='gateway')
<div class="col-lg-12">
  <div class="box-body no-padding">
    <table class="table table-condensed">
      <tbody>
      <tr>
        <td style="padding-top: 20px;"><b>Device</b><br>
          <span style="padding-left: 15px;">Type</span><br>
          <span style="padding-left: 15px;">Manufacture</span><br>
          <span style="padding-left: 15px;">Model</span>
        </td>
        <td><br><br>{{ucfirst($asset->asset_type)}}<br>{{$asset->manufacture}}<br>
          {{$asset->model}}
        </td>
      </tr>
      <tr>
        <td><b>Credentials</b><br>
          <span style="padding-left: 15px;">User Name</span><br>
          <span style="padding-left: 15px;">Password</span>
        </td>
        <td>@if($asset->password)<br>{{$asset->password->login}}<br>{{$asset->password->password}}@endif
        </td>
      </tr>
      <tr>
        <td><b>Network</b><br>
          <span style="padding-left: 15px;">LAN IP Address</span><br>
          <span style="padding-left: 15px;">WAN IP Address</span>
        </td>
        <td>
          <br>{{$asset->lan_ip_address}}<br>{{$asset->wan_ip_address}}
        </td>
    </tr>
    </tbody></table>
  </div>

<h5 style="padding-top: 20px;">Notes</h5>
<textarea class="form-control" rows="4">{{$asset->notes}}</textarea>
</div>
<div class="clearfix"></div>

@endif


@if($asset->asset_type=='pbx')
<div class="col-lg-12">
  <div class="box-body no-padding">
    <table class="table table-condensed">
      <tbody>
      <tr>
        <td style="padding-top: 20px;"><b>Device</b><br>
          <span style="padding-left: 15px;">Type</span><br>
          <span style="padding-left: 15px;">Manufacture</span><br>
          <span style="padding-left: 15px;">Operating System</span><br>
        </td>
        <td><br><br>{{strtoupper($asset->asset_type)}}<br>{{$asset->manufacture}}<br>
          {{$asset->os}}
        </td>
      </tr>
      <tr>
        <td><b>Credentials</b><br>
          <span style="padding-left: 15px;">Admin GUI</span><br>
          <span style="padding-left: 15px;">User Name</span><br>
          <span style="padding-left: 15px;">Password</span>
        </td>
        <td><br><a href="{{$asset->admin_gui_address}}">{{$asset->admin_gui_address}}</a><br>@if($asset->password)<br>{{$asset->password->login}}<br>{{$asset->password->password}}@endif
        </td>
      </tr>
      <tr>
        <td><b>Network</b><br>
          <span style="padding-left: 15px;">Hostname</span><br>
          <span style="padding-left: 15px;">IP Address</span><br>
          <span style="padding-left: 15px;">Cloud or Onsite</span>
        </td>
        <td>
          <br>{{$asset->host_name}}<br>{{$asset->ip_address}}<br>{{$asset->hosted}}
        </td>
    </tr>
    </tbody></table>
  </div>

<h5 style="padding-top: 20px;">Notes</h5>
<textarea class="form-control" rows="4">{{$asset->notes}}</textarea>
</div>
<div class="clearfix"></div>
@endif


@if($asset->asset_type=='server')
<?php $server_type = ['physical'=>'Physical', 'virtual' =>'Virtual'];?>

<div class="col-lg-12">
  <div class="box-body no-padding">
    <table class="table table-condensed">
      <tbody>
      <tr>
        <td style="padding-top: 20px;"><b>Device</b><br>
          <span style="padding-left: 15px;">Type</span><br>
        </td>
        <td><br><br>
          @if(isset($asset->virtual_type->title))
            {{ucfirst($asset->virtual_type->title)}}
          @endif
          {{ucfirst($server_type[$asset->server_type])}} <br> {{ucfirst($asset->asset_type)}}<br>{{$asset->manufacture}}<br>
          {{$asset->os}}
        </td>
      </tr>
      <tr>
        <td><b>Credentials</b><br>
          <span style="padding-left: 15px;">Admin GUI</span><br>
          <span style="padding-left: 15px;">User Name</span><br>
          <span style="padding-left: 15px;">Password</span>
        </td>
        <td><br><a href="{{$asset->admin_gui_address}}">{{$asset->admin_gui_address}}</a><br>{{$asset->user_name}}<br>{{$asset->password}}
        </td>
      </tr>
      <tr>
        <td><b>Network</b><br>
          <span style="padding-left: 15px;">Hostname</span><br>
          <span style="padding-left: 15px;">IP Address</span><br>
          <span style="padding-left: 15px;">Roles</span>
        </td>
        <td>
          <br>{{$asset->host_name}}<br>{{$asset->ip_address}}<br>
            <?php $roles = json_decode($asset->roles);?>
          @if(isset($roles))
          @foreach ($roles as $role)
            @if(isset($asset_roles[$role]))
            <span class="label label-success">{{$asset_roles[$role]}}</span>
            @endif
          @endforeach
          @endif
        </td>
    </tr>
    </tbody></table>
  </div>

<h5 style="padding-top: 20px;">Notes</h5>
<textarea class="form-control" rows="4">{{$asset->notes}}</textarea>
</div>
<div class="clearfix"></div>

@endif

<!-- <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>
<p>
  <span class="label label-danger">UI Design</span>
  <span class="label label-success">Coding</span>
  <span class="label label-info">Javascript</span>
  <span class="label label-warning">PHP</span>
  <span class="label label-primary">Node.js</span>
</p> -->
  <div class="clearfix"></div>
