@extends('admin.main')


@section('content')

@section('content_header')
 <h1>
            Settings
    </h1>
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-gears"></i> Settings
        </li>
    </ol>
@endsection

<section class="content">
    <div class="row">

        <div class="col-xs-12">

             @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            @endif

             @if(session('success'))
            <div class="alert alert-success  alert-dismissable">
           <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <ul>

                    <li>{{ session('success') }}</li>

                </ul>
            </div>

            @endif
<?php //$auth = Auth::user()->hasRole('admin');
//dd($auth);?>



              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                        Global Settings
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">

                      <div class="box box-default collapsed-box">
                                  <div class="box-header with-border">
                                    <h3 class="box-title">Expandable</h3>

                                    <div class="box-tools pull-right">
                                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                      </button>
                                    </div>
                                    <!-- /.box-tools -->
                                  </div>
                                  <!-- /.box-header -->
                                  <div class="box-body" style="display: none;">
                                    The body of the box
                                  </div>
                                  <!-- /.box-body -->
                                </div>

                    @permission('view_role_permission')
                    <div class="box-body" id="tab_role"></div>
                    <div class="box-body" id="tab_permissions"></div>
                    @endpermission

                    </div>
                  </div>
                </div>
                <div class="panel box">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                        Collapsible Group Danger
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                      wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                      eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                      assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                      nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                      farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                      labore sustainable VHS.
                    </div>
                  </div>
                </div>
                <div class="panel box">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="" aria-expanded="true">
                        Collapsible Group Success
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse in" aria-expanded="true">
                    <div class="box-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                      wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                      eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                      assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                      nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                      farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                      labore sustainable VHS.
                    </div>
                  </div>
                </div>
              </div>


            <div class="box">
              <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-gear"></i> Global Settings</h3>
                </div>
                <div class="box-body">
                @permission('view_role_permission')
                <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">Security</h4>
                      <div class="box box-solid">
                        <div class="box-header with-border">
                          <h3 class="box-title">Roles & Permissions</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                          <div class="box-group" id="accordion">
                            <div class="panel box box-primary">
                              <div class="box-header with-border">
                                <h4 class="box-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#roles">
                                    Roles
                                  </a>
                                </h4>
                              </div>
                              <div id="roles" class="panel-collapse collapse in">
                                <div class="box-body" id="tab_role">

                                </div>
                              </div>
                            </div>

                            <div class="panel box box-success">
                              <div class="box-header with-border">
                                <h4 class="box-title">
                                  <a data-toggle="collapse" data-parent="#accordion" href="#permissions">
                                    Permissions
                                  </a>
                                </h4>
                              </div>
                              <div id="permissions" class="panel-collapse collapse">
                                <div class="box-body" id="tab_permissions">

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                @endpermission


                @permission('view_role_permission')
                <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">System</h4>


                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-pills">
                              <li class="active"><a href="#tab_date_time" data-toggle="pill">Date/Time format</a></li>
                              <li><a href="#tab_time_zone" data-toggle="pill">Time Zone</a></li>
                              <li><a href="#tab_telephone" data-toggle="pill">Phone/Fax Numbers</a></li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_date_time">

                                  <form id="date_time">

                                    <?php $date_format = ['dd/mm/yyyy|d/m/Y'=>'dd/mm/yyyy',
                                                          'mm/dd/yyyy|m/d/Y'=>'mm/dd/yyyy',
                                                          'dd-mm-yyyy|d-m-Y'=>'dd-mm-yyyy',
                                                          'mm-dd-yyyy|m-d-Y'=>'mm-dd-yyyy'];?>
                                      <div class="form-group col-lg-6">
                                          <label>Date Format</label>
                                         {!! Form::select('date_format', $date_format,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Date Format','id'=>'date_format'])!!}
                                          <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                                      </div>
                                       <?php $time_format = ['hh:mm:ss'=>'hh:mm:ss',
                                                          'hh:mm:ss am/pm'=>'hh:mm:ss am/pm'];?>
                                      <div class="form-group col-lg-6">
                                          <label>Time Format</label>
                                          {!! Form::select('time_format', $time_format,'',['class'=>'form-control multiselect','placeholder' => 'Pick a Time Format','id'=>'time_format'])!!}
                                      </div>
                                  </form>

                                  <div class="form-group pull-right">
                                        <button class="btn btn-md btn-success btn-block" id="date_time_update">Update</button>
                                  </div>
                                   <div class="clearfix"></div>
                                </div>
                              <div class="tab-pane" id="tab_time_zone">
                                <form id="time_zone_form">
                                  <div class="col-lg-12">
                                    <div class="form-group col-lg-6">
                                      <label>Time Zone</label>
                                        <?php //$time_zones =[];?>
                                       {!! Form::select('time_zone', $time_zones,$global_time_zone,['class'=>'form-control multiselect col-lg-6','placeholder' => 'Pick a time zone'])!!}
                                    </div>
                                  </div>
                                </form>
                                   <div class="form-group pull-right">
                                        <button class="btn btn-md btn-success btn-block" id="time_zone_update">Update</button>
                                  </div>
                                <div class="clearfix"></div>
                              </div><!-- /.tab-pane -->


                               <div class="tab-pane" id="tab_telephone">
                                <form id="tel_fax_form">
                                  <div class="col-lg-12">
                                    <div class="form-group col-lg-6">
                                      <label>Telephone</label>
                                        <?php $telephone =['(999) 999-9999'=>'(xxx) xxx-xxxx',
                                                            '+1(999) 999-9999'=>'+1(xxx) xxx-xxxx'];?>
                                       {!! Form::select('telephone', $telephone,$global_phone_number_mask,['class'=>'form-control multiselect col-lg-6','placeholder' => 'Pick a phone number format'])!!}
                                    </div>
                                    <div class="form-group col-lg-6">
                                      <label>Mobile</label>
                                        <?php $mobile =['(999) 999-9999'=>'(xxx) xxx-xxxx',
                                                            '+1(999) 999-9999'=>'+1(xxx) xxx-xxxx'];?>
                                       {!! Form::select('mobile', $mobile,$global_mobile_number_mask,['class'=>'form-control multiselect col-lg-6','placeholder' => 'Pick a mobile number format'])!!}
                                    </div>
                                    <div class="form-group col-lg-6">
                                      <label>Fax</label>
                                         <?php $fax =['(999) 999-9999'=>'(xxx) xxx-xxxx',
                                                            '+1(999) 999-9999'=>'+1(xxx) xxx-xxxx'];?>
                                       {!! Form::select('fax', $fax,$global_fax_number_mask,['class'=>'form-control multiselect col-lg-6','placeholder' => 'Pick a fax number format'])!!}
                                    </div>
                                  </div>
                                </form>
                                   <div class="form-group pull-right">
                                        <button class="btn btn-md btn-success btn-block" id="tel_fax_update">Update</button>
                                  </div>
                                <div class="clearfix"></div>
                              </div><!-- /.tab-pane -->

                            </div><!-- /.tab-content -->
                      </div>

                    </div><!-- /.box-body -->
                </div>
                @endpermission



                 <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">Ticketing</h4>


                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-pills">
                              <li class="active"><a href="#ticket_statuses" data-toggle="pill">Statuses</a></li>


                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="ticket_statuses">

                              </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                      </div>
                    </div><!-- /.box-body -->
                </div>


                <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">CRM</h4>

                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-pills">
                              <li class="active"><a href="#tab_rates" data-toggle="pill">Default Rates</a></li>
                             <li ><a href="#tab_billing" data-toggle="pill">Billing period</a></li>
                              <li ><a href="#tab_service_items" data-toggle="pill">Service items</a></li>

                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_rates">

                              </div><!-- /.tab-pane -->

                              <div class="tab-pane" id="tab_billing">

                              </div><!-- /.tab-pane -->
                              <div class="tab-pane" id="tab_service_items">

                              </div>
                            </div><!-- /.tab-content -->
                      </div>
                    </div><!-- /.box-body -->
                </div>
             @permission('view_integration')
                 <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">Integrations</h4>

                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-pills">
                              <li class="active"><a href="#tab_zoho" data-toggle="pill">Zoho Invoices</a></li>
                               <li><a href="#tab_slack" data-toggle="pill">Slack</a></li>
                                @permission('view_gmail_integration')
                                 <li><a href="#tab_gmail_integration" data-toggle="pill">Gmail Integration</a></li>
                                @endpermission

                            </ul>
                            <div class="tab-content">
                              <div class="tab-pane active" id="tab_zoho">

                              </div>
                              <div  class="tab-pane" id="tab_slack">
                              </div>

                                @permission('view_gmail_integration')
                                  <div class="tab-pane" id="tab_gmail_integration">
                                    <div class="col-lg-12">
                                      <div class="col-lg-4">

                                        <div class="box box-solid">
                                            <div class="box-header with-border border-top ">
                                              <h3 class="box-title">Imap Credentials</h3>
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <form id="imap_credentials">

                                                  <div class="form-group">
                                                      <label>Email Address</label>
                                                      {!! Form::input('email','gmail_email',null, ['placeholder'=>"Email",'class'=>"form-control"]) !!}
                                                      <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                                                  </div>

                                                  <div class="form-group">
                                                      <label>Gmail Password</label>
                                                      {!! Form::input('password','gmail_password',null, ['placeholder'=>"Gmail Password",'class'=>"form-control"]) !!}
                                                      <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                                  </div>
                                                </form>

                                             <div class="form-group pull-right">
                                                <button class="btn btn-md btn-success btn-block" id="imap_update">Update</button>
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>

                                      </div>
                                      <div class="col-lg-4">
                                        <div class="box box-solid">
                                          <div class="box-header with-border border-top ">
                                              <h3 class="box-title">Gmail SMTP</h3>
                                          </div><!-- /.box-header -->
                                          <div class="box-body">
                                                <form id="smtp_credentials">
                                                  <div class="form-group">
                                                      <label>Server Address</label>
                                                      {!! Form::input('text','server_address',null, ['placeholder'=>"Server address",'class'=>"form-control"]) !!}
                                                      <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                                                  </div>

                                                  <div class="form-group">
                                                      <label>Gmail Address</label>
                                                      {!! Form::input('text','smtp_address',null, ['placeholder'=>"Gmail Address",'class'=>"form-control"]) !!}
                                                      <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                                  </div>
                                                 <div class="form-group">
                                                      <label>Gmail Password</label>
                                                      {!! Form::input('password','smtp_password',null, ['placeholder'=>"Gmail Password",'class'=>"form-control"]) !!}
                                                      <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                                  </div>
                                                  <div class="form-group">
                                                      <label>Port</label>
                                                      {!! Form::input('text','smtp_port',null, ['placeholder'=>"Port",'class'=>"form-control"]) !!}
                                                      <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                                  </div>

                                                </form>

                                                  <div class="form-group pull-right">
                                                    <button  class="btn btn-md btn-success btn-block  " id="smtp_update">Update</button>
                                                  </div>
                                        </div>
                                            </div>
                                      </div>

                                      <div class="col-lg-4">
                                        <div class="box box-solid">
                                                <div class="box-header with-border border-top ">
                                                  <h3 class="box-title">Gmail API credentials</h3>
                                                </div><!-- /.box-header -->
                                                  <div class="box-body">
                                                  <div id="err_gmail_api"></div>
                                                      <form id="gmail_api_credentials">
                                                        <div class="form-group">
                                                            <label>Client ID</label>
                                                            {!! Form::input('text','gmail_auth_client_id',null, ['placeholder'=>"Client ID",'class'=>"form-control",'id'=>'gmail_auth_client_id']) !!}
                                                            <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Client Secret</label>
                                                            {!! Form::input('text','gmail_auth_client_secret',null, ['placeholder'=>"Client Secret",'class'=>"form-control",'id'=>'gmail_auth_client_secret']) !!}
                                                            <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                                        </div>
                                                          <div class="form-group">
                                                            <label>Redirect URI</label>
                                                            {!! Form::input('text','redirect_uri',null, ['placeholder'=>"Redirect URI",'class'=>"form-control",'id'=>'redirect_uri']) !!}
                                                            <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                                                        </div>

                                                      </form>

                                                         <div class="form-group pull-right">
                                                            <button class="btn btn-md btn-success btn-block" id="gmail_api_update">Update</button>
                                                            </div>
                                                  </div>
                                        </div>
                                      </div><!-- /.tab-pane -->

                                    </div><!-- /.tab-content -->
                                    <div class="clearfix"></div>
                                  </div>
                                @endpermission
                            </div><!-- /.tab-content -->
                      </div>
                    </div><!-- /.box-body -->
                </div>
            @endpermission

                 <div class="col-lg-12">

                      <h4 class="box-title bottom-border padding-bottom-8">Assets</h4>

                    <div class="box-body">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-pills">
                              <li class="active"><a href="#asset_roles" data-toggle="pill">Asset server roles</a></li>
                              <li ><a href="#asset_v_types" data-toggle="pill">Asset server virtual types</a></li>

                            </ul>
                            <div class="tab-content">

                              <div class="tab-pane active" id="asset_roles">
                                   @include('assets::ajax_settings.ajax_index')
                              </div><!-- /.tab-pane -->
                               <div class="tab-pane" id="asset_v_types">
                                   @include('assets::ajax_settings.ajax_index_v_types')
                              </div>

                            </div><!-- /.tab-content -->
                      </div>
                    </div><!-- /.box-body -->
                </div>

                </div>


                 <div class="box-header with-border top-border bot_10px">
                    <h3 class="box-title"><i class="fa fa-gear"></i> User Settings</h3>
                </div>
                <div class="box-body">

                  <div class="nav-tabs-custom">
                      <ul class="nav nav-pills">

                        <li class="active"><a href="#tab_profile" data-toggle="pill">Profile</a></li>


                        <li><a href="#tab_email" data-toggle="pill">Email Template</a></li>
                        <li><a href="#tab_email_signature" data-toggle="pill">Email Signature</a></li>
                       
                         
                        <li><a href="#tab_email" data-toggle="tab">Email Template</a></li>
                        <li><a href="#tab_email_signature" data-toggle="tab">Email Signature</a></li>


                      </ul>
                      <div class="tab-content">

                        <div class="tab-pane active" id="tab_profile">
                          <div class="box-body table-responsive">
                            <table class="table table-hover" id="dt_table">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Phone</th>

                                  <th>Created at</th>
                                   <th>Mobile</th>
                                  <th>Email</th>
                                  <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->f_name.' '.$user->l_name}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{ date($global_date,strtotime($user->created_at)) }}</td>
                                    <td>{{$user->mobile}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="{{$user->id}}" id="modaal" data-target="#modal-edit-user">
                                             <i class="fa fa-pencil"></i>Edit</button>
                                    </td>
                                  </tr>
                                </tbody>

                            </table>
                          </div>

                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_email">
                           <div class="col-lg-8">

                                          <form id="email_template_form">
                                             <div class="form-group">

                                                {!! Form::textarea('email_template',null, ['placeholder'=>"",'class'=>"form-control textarea",'id'=>'email_template','rows'=>10]) !!}
                                              </div>
                                          </form>
                                           <button type="button" class="btn btn-primary btn-sm pull-right" id="email_template_update">Update</button>
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
                               <button type="button" class="btn btn-primary btn-sm pull-right" id="email_signature_update">Update</button>
                            </div>
                        </div>




                         <div class="clearfix"></div>
                      </div>
                  </div>
                </div>
    </div>
    </div>
    </div>
</section>

@include('admin.permissions.delete_modal_ajax_permission')


@include('admin.roles.ajax_create_role')
@include('admin.roles.ajax_edit_role')
@include('admin.roles.delete_modal_role')

@include('admin.setting.ajax_edit_user')

@include('admin.permissions.ajax_create_permission')
@include('admin.permissions.ajax_edit_permission')


@include('crm::crm.def_rate.ajax_create_rate')
@include('crm::crm.def_rate.delete_modal')


@include('crm::billing.ajax_create_billing')
@include('crm::billing.delete_modal')



@include('crm::zoho.reset_modal_ajax')

@include('crm::service_item.delete_modal_service_item')
@include('crm::service_item.ajax_add')


 @include('assets::ajax_settings.delete_modal')

 @include('assets::ajax_settings.ajax_create_asset_role')


 @include('assets::ajax_settings.delete_v_type_modal')

 @include('assets::ajax_settings.ajax_create_asset_v_type')

 @include('admin.setting.slack.reset_modal_ajax')

@endsection
@section('script')

<!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
<script src="/DataTables/datatables.min.js"></script>
{{--  <script src="/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
   <script src="/ckeditor/config.js"></script>--}}
<script src="/vendor/summernote/summernote.js"></script>
<script src="/vendor/summernote/summernote-floats-bs.min.js"></script>
<script>

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

                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_email');

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

function slack_authorize()
{
  $.ajax({
          url: "{{ URL::route('admin.setting.slack_token_request')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'GET',
          dataType: 'json',
          data: $('#gmail_api_credentials').serialize(),
          success: function(response){
              popupwindow(response.url,'api',800,400);
            }
          });

}

function popupwindow(url, title, w, h) {
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
</script>
@endsection

@section('document.ready')
@parent
  $(".colorpicker").colorpicker({
           format:'hex'
        });
@permission('view_role_permission')
    $.get('/admin/role',function(response ) {
    $('#tab_role').html(response);
       },"html"
        );
@endpermission

    $.get('{{ URL::route("admin.tickets.status.list")}}',function(response) {
    $('#ticket_statuses').html(response);
       },"html"
        );


          $.get('{{URL::route("admin.setting.google_auth")}}',function(response ) {
              $('#gmail_api_credentials').find('input[name="gmail_auth_client_id"]').val(response.gmail_auth_client_id);
              $('#gmail_api_credentials').find('input[name="gmail_auth_client_secret"]').val(response.gmail_auth_client_secret);
              $('#gmail_api_credentials').find('input[name="redirect_uri"]').val(response.redirect_uri);

           });




        $('#dt_table_server_roles').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.assets.list_server_roles') !!}',
                columns: [
                    { data: 'title', name: 'title' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]
            });
          $("#dt_table_server_roles").css("width","100%");
          $('#dt_table_server_roles_wrapper').addClass('padding-top-40');
          $('.pagination').addClass('pull-right');


           $('#dt_table_v_types').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.assets.list_server_virtual_types') !!}',
                columns: [
                    { data: 'title', name: 'title' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]
            });
          $("#dt_table_v_types").css("width","100%");
          $('#dt_table_v_types_wrapper').addClass('padding-top-40');
         // $('.pagination').addClass('pull-right');




@permission('view_role_permission')
     $.get('/admin/permissions',function(response ) {
        $('#tab_permissions').html(response);
        $('#dt_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.permissions.list') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}

                ]
            });
  $("#dt_table").css("width","100%");
        $('#dt_table_wrapper').addClass('padding-top-40');
          $('.pagination').addClass('pull-right');

            },"html"
        );
@endpermission

@permission('customer_billing_list')
         $.get('{{URL::route("admin.crm.default_rates")}}',function(response ) {
            $('#tab_rates').html(response);
               },"html"
        );
@endpermission
@permission('customer_billing_list')
        $.get('{{URL::route("admin.billing.index")}}',function(response ) {
            $('#tab_billing').html(response);
               },"html"
        );
@endpermission
@permission('view_integration')
  $.get('{{URL::route("admin.crm.zoho_credentials")}}',function(response ) {
            $('#tab_zoho').html(response);

            $( ".edit_zoho" ).click(function() {

               $.ajax({
                      url: "{{ URL::route('admin.crm.zoho_store')}}",
                      //headers: {'X-CSRF-TOKEN': token},
                      type: 'POST',
                      dataType: 'json',
                      data: $('#edit_zoho_form').serialize(),
                      success: function(response){
                      if(response.success)
                      {

                            $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_zoho');

                               $.get('{{URL::route("admin.crm.zoho_credentials")}}',function(response ) {
                                          $('#tab_zoho').html(response);
                                             },"html"
                                      );

                         alert_hide();
                      }

                      }

                  });
             });

               },"html"
        );
  @endpermission

  @permission('view_integration')
    $.get('{{URL::route("admin.setting.slack_get")}}',function(response ) {
            $('#tab_slack').html(response);

            $( ".update_slack" ).click(function() {

               $.ajax({
                      url: "{{ URL::route('admin.setting.slack_store')}}",
                      type: 'POST',
                      dataType: 'json',
                      data: $('#update_slack_form').serialize(),
                      success: function(response){
                        if(response.success)
                        {
                              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_slack');

                                 $.get('{{URL::route("admin.setting.slack_get")}}',function(response ) {
                                            $('#tab_slack').html(response);
                                               },"html"
                                        );
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
                       $(html_error).insertBefore('#tab_slack');


                    // Render the errors with js ...
                    alert_hide();
                  }

                  });
             });

            },"html");
  @endpermission
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
    focus: true});

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
    focus: true});



        $.get('{{URL::route("admin.setting.get_email_data")}}',function(response ) {
        //console.log(response.email_template);
                              $('#email_template').summernote('code', response.email_template);
                              //$('#email_template').code(response.email_template);
                             // $('#email_template_textarea').summernote('editor.insertText', response.email_template);
                                 },"json"
                          );
        $.get('{{URL::route("admin.setting.get_email_signature")}}',function(response ) {

           $('#email_signature').summernote('code', response.email_signature);
        },"json"
        );



          $.get('{{URL::route("admin.setting.get_date_time")}}',function(response ) {
                  //$('#tab_email_signature').html(response);

                  $('option[value="'+response.config_date+'"]', $('#date_format')).prop('selected', true);

                  $('#date_format').multiselect('refresh');

                  $('option[value="'+response.config_time+'"]', $('#time_format')).prop('selected', true);

                  $('#time_format').multiselect('refresh');

                     },"json"
              );


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

$('#time_zone_update').click(function() {

  $.ajax({
        url: "{{ URL::route('admin.setting.time_zone_update')}}",
        type: 'POST',
        dataType: 'json',
        data: $('#time_zone_form').serialize(),
        success: function(response){
        if(response.success)
        {

              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_time_zone');


           alert_hide();
        }

        }

    });
});


$('#tel_fax_update').click(function() {

  $.ajax({
        url: "{{ URL::route('admin.setting.tel_fax_update')}}",
        type: 'POST',
        dataType: 'json',
        data: $('#tel_fax_form').serialize(),
        success: function(response){
        if(response.success)
        {

              $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_telephone');


           alert_hide();
        }

        }

    });
});

{{-- $('#email_intro_update').click(function() {

 email_update();
});
 --}}
   $('#smtp_update').click(function() {


   $.ajax({
          url: "{{ URL::route('admin.setting.smtp_store')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: $('#smtp_credentials').serialize(),
          success: function(response){
          if(response.success)
          {

                $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_gmail_integration');

                    $.get('{{URL::route("admin.setting.smtp")}}',function(response ) {
                //$('#tab_email_signature').html(response);
               $('#smtp_credentials').find('input[name="server_address"]').val(response.server_address);
               $('#smtp_credentials').find('input[name="smtp_address"]').val(response.gmail_address);
                $('#smtp_credentials').find('input[name="smtp_password"]').val(response.password);
                 $('#smtp_credentials').find('input[name="smtp_port"]').val(response.port);
                   },"json"
            );

             alert_hide();
          }

          }

      });

});


   $('#imap_update').click(function() {


   $.ajax({
          url: "{{ URL::route('admin.setting.imap_store')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: $('#imap_credentials').serialize(),
          success: function(response){
          if(response.success)
          {

                $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_gmail_integration');

                 $.get('{{URL::route("admin.setting.imap")}}',function(response ) {
                  //$('#tab_email_signature').html(response);
                 $('#imap_credentials').find('input[name="gmail_email"]').val(response.imap_email);
                 $('#imap_credentials').find('input[name="gmail_password"]').val(response.imap_password);
                     },"json"
              );

             alert_hide();
          }

          }

      });

});

          $.get('{{URL::route("admin.setting.imap")}}',function(response ) {
                  //$('#tab_email_signature').html(response);
                 $('#imap_credentials').find('input[name="gmail_email"]').val(response.imap_email);
                 $('#imap_credentials').find('input[name="gmail_password"]').val(response.imap_password);
                     },"json"
              );

            $.get('{{URL::route("admin.setting.smtp")}}',function(response ) {
                //$('#tab_email_signature').html(response);
               $('#smtp_credentials').find('input[name="server_address"]').val(response.server_address);
               $('#smtp_credentials').find('input[name="smtp_address"]').val(response.gmail_address);
                $('#smtp_credentials').find('input[name="smtp_password"]').val(response.password);
                 $('#smtp_credentials').find('input[name="smtp_port"]').val(response.port);
                   },"json"
            );
 $('#gmail_api_update').click(function() {
  $('#err_gmail_api').html('');
   $.ajax({
          url: "{{ URL::route('admin.setting.gmail_api_update')}}",
          //headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: $('#gmail_api_credentials').serialize(),
          success: function(response){

      //console.log(response.gmail.auth_url);
        popupwindow(response.gmail.auth_url,'api',600,400);

          //console.log(response.gmail.auth_url);
          if(response.success)
          {

              //wins
                $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore('#tab_gmail_integration');



             alert_hide();
          }
           $.get('{{URL::route("admin.setting.google_auth")}}',function(response ) {
              $('#gmail_api_credentials').find('input[name="gmail_auth_client_id"]').val(response.gmail_auth_client_id);
              $('#gmail_api_credentials').find('input[name="gmail_auth_client_secret"]').val(response.gmail_auth_client_secret);
              $('#gmail_api_credentials').find('input[name="redirect_uri"]').val(response.redirect_uri);

           });

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
            $('#err_gmail_api').html(html_error);
            //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();

            // Render the errors with js ...
            alert_hide();
          }
      });

});




@permission('view_integration')
  $.get('{{URL::route("admin.service_item.index")}}',function(response ) {
    $('#tab_service_items').html(response);
       },"html"
        );
@endpermission
@endsection
@section('styles')
@parent
<!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"/> -->
<link rel="stylesheet" href="/DataTables/datatables.min.css">
 <link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
  {{-- <link rel="stylesheet" href="/colorpicker/bootstrap-colorpicker.min.css"/> --}}
   {{-- <link rel="stylesheet" href="/css/bootstrap3-wysihtml5.min.css"/> --}}
   <link href="/vendor/summernote/summernote.css" rel="stylesheet">

<style>

.nav-tabs-custom {

    box-shadow: 0 1px 1px 1px rgba(0, 0, 0, 0.1) !important;

}
.bottom-border {
    border-bottom: 1px solid #f4f4f4;
}
.padding-bottom-8{
    padding-bottom: 8px;
}
.padding-top-10{
  padding-top: 10px;
}
.padding-top-40{
  padding-top: 40px;
}



    .top-border {
        border-top: 1px solid #f4f4f4;
    }
    .top-10px{
        top: 10px;
    }
    .bot_10px{
        margin-bottom: 10px;
    }

    .relative{
        position: relative;
    }
    .left-15px{
        left: 15px;
    }

   .border-top {
    border-top: 1px solid #f4f4f4;
}
</style>
@endsection
