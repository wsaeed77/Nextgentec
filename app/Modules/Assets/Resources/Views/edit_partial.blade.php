
<form id="edit_asset">
  <div class="form-group col-lg-6">
       <label>Name</label>
       {!! Form::input('text','name',$asset->name, ['placeholder'=>"Name",'class'=>"form-control"]) !!}
       <input type="hidden" name="asset_id" value="{{$asset->id}}">
   </div>

     <div class="form-group col-lg-6">
       <label>Customer</label>
        <?php if((session('cust_id')!='') && (session('customer_name')!=''))
                               {
                                  $selected_cust = session('cust_id');?>
             {!! Form::select('customer', $customers,$selected_cust,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','onChange'=>'load_service_items(this.value)', 'id'=>'customers_select','disabled'=>''])!!}
              <input type="hidden" name="customer" value="{{$selected_cust}}">
        <?php } else{ ?>
             {!! Form::select('customer', $customers,$asset->customer->id,['class'=>'form-control multiselect','placeholder' => 'Pick a Customer','onChange'=>'load_service_items(this.value)', 'id'=>'customers_select'])!!}
        <?php }?>

     </div>

     <div class="form-group col-lg-6">
       <label>Location</label>

     <?php if(!$asset->location)
              $selected_location_id='';
            else
              $selected_location_id=$asset->location->id;
     ?>
      {!! Form::select('location', $locations,$selected_location_id,['class'=>'form-control multiselect','placeholder' => 'Pick a Location', 'id'=>'locations'])!!}
     </div>

            <?php $asset_types = ['network'=>'Network',
                                   'gateway' => 'Gateway',
                                   'pbx'=>'PBX',
                                   'server'=>'Server'];?>
            <div class="form-group col-lg-6">
             <label>Asset Type</label>

            {!! Form::select('asset_type', $asset_types,$asset->asset_type,['class'=>'form-control multiselect','placeholder' => 'Pick Asset Type','onChange'=>'cahnge_asset_view(this.value)', 'id'=>'asset_type'])!!}
           </div>



<div class="clearfix"></div>

  			<div class="box-header with-border top-border bot_10px">
          <h3 class="box-title">Asset Detail</h3>
        </div>
        <div id="target_div"></div>
        <div class="clearfix"></div>

</form>

{{-- =================================================================================================--}}
	@if($asset->asset_type=='network')
	   	<div id="network_div" style="display:none;">

       <div class="form-group col-lg-4">
            <label>Mac address</label>
            {!! Form::input('text','mac',$asset->mac_address, ['placeholder'=>"Mac Address",'class'=>"form-control"]) !!}
        </div>
	        <div class="form-group col-lg-4">
	            <label>Manufacture</label>
	            {!! Form::input('text','manufacture',$asset->manufacture, ['placeholder'=>"Manufacture",'class'=>"form-control"]) !!}
	        </div>

	        <div class="form-group col-lg-4">
	            <label>OS</label>
	            {!! Form::input('text','os',$asset->os, ['placeholder'=>"OS",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>Model</label>
	            {!! Form::input('text','model',$asset->model, ['placeholder'=>"Model",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>Ip Address</label>
	            {!! Form::input('text','ip_address',$asset->ip_address, ['placeholder'=>"IP Address",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>User Name</label>
	            {!! Form::input('text','user_name',($asset->password)?$asset->password->login:'', ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>Password</label>
	            {!! Form::input('text','password',($asset->password)?$asset->password->password:'', ['placeholder'=>"Password",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>Is Static?</label>
	            <?php $is_static = ['1'=>'Yes',
	                                '0' =>'No'];?>
	            {!! Form::select('is_static', $is_static,$asset->is_static,['class'=>'form-control','placeholder' => 'Is Static?', 'id'=>'is_static','onChange'=>'show_static_type(this.value)'])!!}
	        </div>

	        <div class="form-group col-lg-4"   style=" @if($asset->is_static==0) {{'display:none'}}" @endif id="static_type">
	            <div class="form-group col-lg-6">
	                <div class="radio top-18px">
	                    <label>
	                        <input type="radio" name="static_type" id="dhcp" value="dhcp" @if($asset->static_type=='dhcp') {{'checked="checked"'}}
	                        @endif>


	                            <span>DHCP</span>

	                    </label>
	                </div>
	            </div>

	            <div class="form-group col-lg-6">
	                <div class="radio top-18px">
	                    <label>
	                        <input type="radio" name="static_type" id="local" value="local"  @if($asset->static_type=='local') {{'checked="checked"'}}
	                        @endif >


	                        <span>Local</span>

	                    </label>
	                </div>
	            </div>

	        </div>

	        <div class="form-group col-lg-12">
	            <label>Notes</label>
	            {!! Form::textarea('notes',$asset->notes, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'network_notes','rows'=>10]) !!}
	        </div>
	    </div>
	@endif

	@if($asset->asset_type=='gateway')
	   <div id="gateway_div" style="display:none;">
	        <div class="form-group col-lg-4">
	            <label>Manufacture</label>
	            {!! Form::input('text','manufacture',$asset->manufacture, ['placeholder'=>"Manufacture",'class'=>"form-control"]) !!}
	        </div>

	        <div class="form-group col-lg-4">
	            <label>Model</label>
	            {!! Form::input('text','model',$asset->model, ['placeholder'=>"Model",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>LAN Ip Address</label>
	            {!! Form::input('text','lan_ip_address',$asset->lan_ip_address, ['placeholder'=>"LAN IP Address",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-4">
	            <label>WAN Ip Address</label>
	            {!! Form::input('text','wan_ip_address',$asset->wan_ip_address, ['placeholder'=>"WAN IP Address",'class'=>"form-control"]) !!}
	        </div>
          <div class="form-group col-lg-4">
             <label>User Name</label>
             {!! Form::input('text','user_name',($asset->password)?$asset->password->login:'', ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
         </div>
	        <div class="form-group col-lg-4">
	            <label>Password</label>
	            {!! Form::input('text','password',($asset->password)?$asset->password->password:'', ['placeholder'=>"Password",'class'=>"form-control"]) !!}
	        </div>
	        <div class="form-group col-lg-12">
	            <label>Notes</label>
	            {!! Form::textarea('notes',$asset->notes, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'gateway_notes','rows'=>10]) !!}
	        </div>
	  </div>
	@endif
	@if($asset->asset_type=='pbx')
	    <div id="pbx_div" style="display:none;">
            <div class="form-group col-lg-4">
                <label>Manufacture</label>
                {!! Form::input('text','manufacture',$asset->manufacture, ['placeholder'=>"Manufacture",'class'=>"form-control"]) !!}
            </div>
             <div class="form-group col-lg-4">
                <label>OS</label>
                {!! Form::input('text','os',$asset->os, ['placeholder'=>"OS",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Host name</label>
                {!! Form::input('text','host_name',$asset->host_name, ['placeholder'=>"Host Name",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Admin GUI Address</label>
                {!! Form::input('text','admin_gui_address',$asset->admin_gui_address, ['placeholder'=>"Admin GUI Address",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Ip Address</label>
                {!! Form::input('text','ip_address',$asset->ip_address, ['placeholder'=>"IP Address",'class'=>"form-control"]) !!}
            </div>
             <div class="form-group col-lg-4">
                <label>User Name</label>
                {!! Form::input('text','user_name',($asset->password)?$asset->password->login:'', ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Password</label>
                {!! Form::input('text','password',($asset->password)?$asset->password->password:'', ['placeholder'=>"Password",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Hosted/Onsite</label>
                {!! Form::input('text','hosted',$asset->hosted, ['placeholder'=>"Hosted/Onsite",'class'=>"form-control"]) !!}
            </div>
	    </div>
	@endif
	@if($asset->asset_type=='server')


        <div id="server_div" style="display:none;">
           <div class="form-group col-lg-4">
                <label>Type</label>
                <?php $server_type = ['physical'=>'Physical', 'hypervisor' =>'Hypervisor', 'guestvm' =>'Guest VM'];?>
                {!! Form::select('server_type', $server_type,$asset->server_type,['class'=>'form-control','placeholder' => 'Server Type', 'id'=>'server_type','onChange'=>'cahnge_server_type(this.value)'])!!}
            </div>

             <div class="form-group col-lg-4" id="virtual_types" style=" @if($asset->server_type=='physical'){{'display:none'}} @endif">
                <label>Virtual Type?</label>

                {!! Form::select('virtual_type', $asset_v_types,$asset->asset_virtual_type_id,['class'=>'form-control','placeholder' => 'Virtual Server Type', 'id'=>'edit_virtual_server_type'])!!}
            </div>


            <div class="form-group col-lg-4">
                <label>Ip Address</label>
                {!! Form::input('text','ip_address',$asset->ip_address, ['placeholder'=>"IP Address",'class'=>"form-control"]) !!}
            </div>

            <div class="form-group col-lg-4">
                <label>Admin GUI Address</label>
                {!! Form::input('text','admin_gui_address',$asset->admin_gui_address, ['placeholder'=>"Admin GUI Address",'class'=>"form-control"]) !!}
            </div>
             <div class="form-group col-lg-4">
                <label>User Name</label>
                {!! Form::input('text','user_name',($asset->password)?$asset->password->login:'', ['placeholder'=>"User Name",'class'=>"form-control"]) !!}
            </div>
            <div class="form-group col-lg-4">
                <label>Password</label>
                {!! Form::input('text','password',($asset->password)?$asset->password->password:'', ['placeholder'=>"Password",'class'=>"form-control"]) !!}
            </div>
             <div class="form-group col-lg-3">
                <label>Host Name</label>
                {!! Form::input('text','host_name',$asset->host_name, ['placeholder'=>"Host Name",'class'=>"form-control"]) !!}
            </div>
           <div class="form-group col-lg-9">
            <label>Roles</label>
             <?php  $roles_selected = json_decode($asset->roles);?>

                 {!! Form::select('roles[]', $asset_roles,$roles_selected,['class'=>'select2','multiple'=>'','style'=>"width: 100%;"])!!}

            </div>


            <div class="form-group col-lg-12">
                <label>Notes</label>
                {!! Form::textarea('notes',$asset->notes, ['placeholder'=>"Notes",'class'=>"form-control textarea",'id'=>'server_notes','rows'=>10]) !!}
            </div>
  		</div>
  	@endif

  <div class="clearfix"></div>
