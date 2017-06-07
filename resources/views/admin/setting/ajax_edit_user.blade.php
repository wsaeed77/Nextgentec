<div class="modal fade" id="modal-edit-user" tabIndex="-1">
  <div class="modal-dialog" style="width: 50%">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Edit Profile</h4>
      </div>
      <div class="modal-body">
          <div id="err_user">
          </div>
        <form id="edit_user">
          <h5>Basic Info</h5>
          <div class="col-lg-6">
              <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="form-group">
                    <label>First Name</label>
                    {!! Form::input('text','f_name',null, ['placeholder'=>"First Name",'class'=>"form-control"]) !!}
                </div>
                <div class="form-group">
                    <label>Email</label>
                    {!! Form::email('email',null, ['placeholder'=>"Email",'class'=>"form-control"]) !!}

                </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
               <label>Last Name</label>
               {!! Form::input('text','l_name',null, ['placeholder'=>"Last Name",'class'=>"form-control"]) !!}
            </div>
          </div>
          <div class="clearfix"></div>
          <h5>Contact Info</h5>
          <div class="col-lg-6">
            <div class="form-group">
               <label>Phone</label>
               {!! Form::input('text','phone',null, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "(999) 999-9999"']) !!}
            </div>
            <div class="form-group">
               <label>Moblie</label>
               {!! Form::input('text','mobile',null, ['placeholder'=>"Phone",'class'=>"form-control dt_mask",'data-mask'=>'','data-inputmask'=> '"mask": "(999) 999-9999"']) !!}
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
               <label>Desk Extension</label>
               {!! Form::input('text','exten',null, ['placeholder'=>"",'class'=>"form-control"]) !!}
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
      <div class="modal-footer">
      <?php //$route  = $route;?>

          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
         <input type="hidden" name="status_id" value="">

          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_user">Close</button>
          <button id="usrupdate" class="btn btn-primary update_user">Update</button>
      </div>
    </div>
  </div>
</div>
@section('script')
@parent
<script src="/colorpicker/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript" src="/js/jquery.inputmask.js"></script>
@endsection

@section('document.ready')
@parent
{{--<script type="text/javascript">--}}
  $('#modal-edit-user').on('show.bs.modal', function(e)
  {
    $(".dt_mask").inputmask();

    //get data-id attribute of the clicked element
    var id = $(e.relatedTarget).data('id');

    $(e.currentTarget).find('input[name="user_id"]').val(id);
    $(e.currentTarget).find('input[name="f_name"]').val('{{$user->f_name}}');
    $(e.currentTarget).find('input[name="l_name"]').val('{{$user->l_name}}');
    $(e.currentTarget).find('input[name="email"]').val('{{$user->email}}');
    $(e.currentTarget).find('input[name="password"]').val('');
    $(e.currentTarget).find('input[name="password_confirmation"]').val('');
    $(e.currentTarget).find('input[name="phone"]').val('{{$user->phone}}');
    $(e.currentTarget).find('input[name="mobile"]').val('{{$user->mobile}}');
    $(e.currentTarget).find('input[name="exten"]').val('{{$user->exten}}');
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
          $('#usrupdate').toggleClass("btn-primary btn-success");
          $('#usrupdate').html("Saved");
          $('#usrupdate').attr('disabled','disabled');
          setTimeout('location.reload()', 800);
          // $( "#close_user" ).trigger( "click" );
          // $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_profile');
          //
          // $.get('/admin/employee/get_user/'+{{$user->id}},function(response) {
          //   $('#tab_profile').html(response);
          // },"html");
          //
          // alert_hide();
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

@endsection
@section('styles')
 @parent
    <link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/>

@endsection
