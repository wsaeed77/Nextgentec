<div style="margin-bottom: 15px;">
  <h4>Extension {{$device->device_label}}</h4>
</div>

<div class="panel panel-default">
	<div class="panel-heading">Details</div>
	<table class="table">
		<tr>
			<td class="width35">Label</td>
			<td>{{$device->device_label}}</td>
		</tr>
		<tr>
			<td class="width35">Vendor</td>
			<td>{{ucfirst($device->device_vendor)}}</td>
		</tr>
		<tr>
			<td class="width35">Model</td>
			<td>{{$model}}</td>
		</tr>
		<tr>
			<td class="width35">Template</td>
			<td>{{ucfirst($device->device_template)}}</td>
		</tr>
		<tr>
			<td class="width35">Provisioned IP</td>
			<td>{{$device->device_provisioned_ip}}</td>
		</tr>
		<tr>
			<td class="width35">Mac Address</td>
			<td>{{strtoupper($device->device_mac_address)}}</td>
		</tr>
		<tr>
			<td class="width35">Description</td>
			<td>{{$device->device_description}}</td>
		</tr>
	</table>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		Notes
	</div>
	<div class="panel-body">
		<form id="update_notes_form">
			<div class="form-group">
				<textarea id="device_notes" name="device_notes" class="form-control">{{$device->notes}}</textarea>
				<input type="hidden" name="device_id" value="{{$device->id}}">
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-primary" onclick="update_notes()">Update</button>
			</div>
		</form>
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
