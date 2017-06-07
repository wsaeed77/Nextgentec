
<div class="modal fade" id="modal-user-settings" tabIndex="-2">
	<div class="modal-dialog  modal-lg" >
		<div class="modal-content" >
			<div class="modal-header">

				<h4 class="modal-title">User Settings</h4>
			</div>
			<div class="modal-body">
				<div class="box-body">

					<div class="nav-tabs-custom">
						<ul class="nav nav-pills">

							<li class="active"><a href="#tab_profile" data-toggle="pill">Profile</a></li>
							<li><a href="#tab_email_profile" data-toggle="pill">Email Template</a></li>
							<li><a href="#tab_email_signature" data-toggle="pill">Email Signature</a></li>
							<li><a href="#tab_user_devices" data-toggle="pill">User Devices</a></li>

						</ul>
						<div class="tab-content">

							<div class="tab-pane active" id="tab_profile">

								<div class="modal-body">
									<div id="err_user">
									</div>
									<form id="edit_user">
										<h5>Basic Info</h5>
										<div class="col-lg-6">
											<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
											<div class="form-group">
												<label>First Name</label>
												{!! Form::input('text','f_name',Auth::user()->f_name, ['placeholder'=>"First Name",'class'=>"form-control"]) !!}
											</div>
											<div class="form-group">
												<label>Email</label>
												{!! Form::email('email',Auth::user()->email, ['placeholder'=>"Email",'class'=>"form-control"]) !!}

											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Last Name</label>
												{!! Form::input('text','l_name',Auth::user()->l_name, ['placeholder'=>"Last Name",'class'=>"form-control"]) !!}
											</div>
										</div>
										<div class="clearfix"></div>
										<h5>Contact Info</h5>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Phone</label>
												{!! Form::input('text','phone',Auth::user()->phone, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "(999) 999-9999"']) !!}
											</div>
											<div class="form-group">
												<label>Moblie</label>
												{!! Form::input('text','mobile',Auth::user()->mobile, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "(999) 999-9999"']) !!}
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Desk Extension</label>
												{!! Form::input('text','exten',Auth::user()->exten, ['placeholder'=>"",'class'=>"form-control"]) !!}
											</div>
										</div>
										<div class="clearfix"></div>
										<h5>Change Password</h5>
										<div class="col-lg-6">
											<div class="form-group">
												<label>New Password</label>
												{!! Form::password('password', ['placeholder'=>"",'class'=>"form-control",'autocomplete'=>'off']) !!}
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Confirm Password</label>
												{!! Form::password('password_confirmation', ['placeholder'=>"",'class'=>"form-control"]) !!}
											</div>
										</div>
									</form>
									<div class="clearfix"></div>
								</div>

								<!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
								<input type="hidden" name="status_id" value="">
								<button id="usrupdate" class="btn btn-primary update_user">Update</button>

							</div><!-- /.tab-pane -->
							<div class="tab-pane" id="tab_email_profile">
								<div class="col-lg-8">

									<form id="email_template_form">
										<div class="form-group">

											{!! Form::textarea('email_template',null, ['placeholder'=>"",'class'=>"form-control textarea",'id'=>'email_template','rows'=>10]) !!}
										</div>
									</form>
									<button type="button" class="btn btn-primary" id="email_template_update">Update</button>
								</div>
								<div class="col-lg-4">

									<div class="box box-solid">
										<div class="box-header with-border border-top ">
											<h3 class="box-title">Variable placeholders</h3>
										</div><!-- /.box-header -->
										<div class="box-body">
											<ul>
												<li>Receipient name : %firstname%</li>
												<li>Receipient name : %lastname%</li>
												<li>Receipient company : %companyname%</li>
												<li>Email body : %response%</li>

											</ul>
										</div>
									</div>
								</div>


							</div><!-- /.tab-pane -->

							<div class="tab-pane" id="tab_email_signature">

								<div class="col-lg-8">

									<form id="email_signature_form">
										<div class="form-group">

											{!! Form::textarea('email_signature',null, ['placeholder'=>"",'class'=>"form-control textarea",'id'=>'email_signature','rows'=>10]) !!}
										</div>
									</form>
									<button type="button" class="btn btn-primary" id="email_signature_update">Update</button>
								</div>
							</div>
							<div id="msg_devices"></div>
							<div class="tab-pane" id="tab_user_devices">

								<div class="col-lg-12">

									<div class="tab-pane active table-responsive" >
										<table class="table table-hover" id="vendor_dt_table">
											<thead>
												<tr>
													<th>Device Extention</th>
													<th>Operating System</th>
													<th>Browser</th>
													<th>action</th>
												</tr>
											</thead>
											<tbody id="user_devices_tbl">
												
											</tbody>
										</table>
									</div><!-- /.tab-pane -->
								</div>
							</div>
							<div class="clearfix"></div>
						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" id="close_user">Close</button>

				</div>

			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	

	function delete_extention(id){
		$.ajax({
			url: "/admin/settings/delete_user_device/"+id,
                //headers: {'X-CSRF-TOKEN': token},
                type: 'GET',
                dataType: 'json',

                success: function(response){
                	if(response.success)
                	{

                		$('#msg_devices').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');

                		alert_hide();
                		fetch_user_devices();
                	}

                }

            });
		
	}

	function fetch_user_devices(){
		$.get('{{URL::route("admin.setting.get_user_devices")}}',function(response ) {
			var returns='';
			
			var j=0;
			$.each(response,function(i,item){
				returns += '<tr><td>'+item.extention+'</td><td>'+item.operating_system+'</td><td>'+item.brower_name+'</td><td><button  onclick="delete_extention('+item.id+')" class="btn btn-danger btn-xs" href="s"><i class="fa fa-times-circle"></i></button></td></tr>'
				j++;
			})
			if(j!=0){
				$('#user_devices_tbl').html(returns);
			}else{
				$('#user_devices_tbl').html('<span>There is no saved device<span>');
			}
		},"json"
		);
	}

	function email_update()
	{
    {{-- for ( instance in CKEDITOR.instances )
    	CKEDITOR.instances[instance].updateElement(); --}}


   // data.signature = $('#signature_form').serialize();
   // data.intro = $('#email_intro_form').serialize();
    //console.log();
      // console.log(data1);
      $.ajax({
      	url: "{{ URL::route('admin.setting.update_email_data')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: 'email_template='+$('#email_template_form').find('textarea').val(),
                success: function(response){
                	if(response.success)
                	{

                		$('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_email_profile');

                		$.get('{{URL::route("admin.setting.get_email_data")}}',function(response ) {

                                    //$('#email_template').code(response.email_template);
                                    $('#email_template').summernote('code', response.email_template);
                                },"json"
                                );

                		alert_hide();
                	}

                }

            });


  }

</script>

@section('document.ready')
@parent
{{--<script type="text/javascript">--}}
$('#modal-user-settings').on('show.bs.modal', function(e)
{
	
	$(".dt_mask").inputmask();

	//get data-id attribute of the clicked element
	var id = $(e.relatedTarget).data('id');

	{{-- $('input[name="user_id"]').val(id);
	$('input[name="f_name"]').val('{{$user->f_name}}');
	$('input[name="l_name"]').val('{{$user->l_name}}');
	$('input[name="email"]').val('{{$user->email}}');
	$('input[name="password"]').val('');
	$('input[name="password_confirmation"]').val('');
	$('input[name="phone"]').val('{{$user->phone}}');
	$('input[name="mobile"]').val('{{$user->mobile}}');
	$('input[name="exten"]').val('{{$user->exten}}'); --}}
	$.get('{{URL::route("admin.setting.get_email_signature")}}',function(response ) {

	$('#email_signature').summernote('code', response.email_signature);

},"json"
);


$.get('{{URL::route("admin.setting.get_email_data")}}',function(response ) {
//console.log(response.email_template);
$('#email_template').summernote('code', response.email_template);
//$('#email_template').code(response.email_template);
// $('#email_template_textarea').summernote('editor.insertText', response.email_template);
},"json"
);


fetch_user_devices();





$.get('{{URL::route("admin.setting.get_date_time")}}',function(response ) {
//$('#tab_email_signature').html(response);

$('option[value="'+response.config_date+'"]', $('#date_format')).prop('selected', true);

$('#date_format').multiselect('refresh');

$('option[value="'+response.config_time+'"]', $('#time_format')).prop('selected', true);

$('#time_format').multiselect('refresh');

},"json"
);

});



$( ".update_user" ).click(function()
{

	$.ajax({
	url: "{{ URL::route('admin.employee.ajax_store')}}",
	//headers: {'X-CSRF-TOKEN': token},
	type: 'POST',
	dataType: 'json',
	data: $('#edit_user').serialize(),
	success: function(response){
	if(response.success) {
	$('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_profile');
	$('#usrupdate').toggleClass("btn-primary btn-success");
	$('#usrupdate').html("Saved");
	$('#usrupdate').attr('disabled','disabled');

	alert_hide();

}
},
error: function(data){
var errors = data.responseJSON;
//console.log(errors);
var html_error = '<div  class="alert alert-danger"><ul>';
$.each(errors, function (key, value)
{
	html_error +='<li>'+value+'</li>';
})
html_error += "</ul></div>";
$('#err_user').html(html_error);
}
});
});


$('#email_template').summernote({ lang: 'en-US',
callbacks: {
onImageUpload: function(files) {
//console.log(files);
// console.log($editable);
uploadImage(files[0],'email_template','email_template');
}
},
dialogsInBody: true,
height: 400,                 // set editor height
minHeight: null,             // set minimum height of editor
maxHeight: null,             // set maximum height of editor
focus: true
});

$('#email_signature').summernote({ lang: 'en-US',
callbacks: {
onImageUpload: function(files) {
//console.log(files);
// console.log($editable);
uploadImage(files[0],'email_signature','email_signature');
}
},
dialogsInBody: true,
height: 400,                 // set editor height
minHeight: null,             // set minimum height of editor
maxHeight: null,             // set maximum height of editor
focus: true
});








$('#date_time_update').click(function() {

$.ajax({
url: "{{ URL::route('admin.setting.update_date_time')}}",
//headers: {'X-CSRF-TOKEN': token},
type: 'POST',
dataType: 'json',
data: $('#date_time').serialize(),
success: function(response){
if(response.success)
{

	$('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_date_time');

	$.get('{{URL::route("admin.setting.get_date_time")}}',function(response ) {

	$('option[value="'+response.config_date+'"]', $('#date_format')).prop('selected', true);

	$('#date_format').multiselect('refresh');

	$('option[value="'+response.config_time+'"]', $('#time_format')).prop('selected', true);

	$('#time_format').multiselect('refresh');

},"json"
);

alert_hide();
}

}

});
});


$('#email_template_update').click(function() {

email_update();
});


$('#email_signature_update').click(function() {

$.ajax({
url: "{{ URL::route('admin.setting.update_email_signature')}}",
type: 'POST',
dataType: 'json',
data: 'email_signature='+$('#email_signature_form').find('textarea').val(),
success: function(response){
if(response.success)
{

	$('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_email_signature');

	$.get('{{URL::route("admin.setting.get_email_signature")}}',function(response ) {


	$('#email_signature').summernote('code', response.email_signature);
},"json"
);

alert_hide();
}

}

});
});

@endsection





