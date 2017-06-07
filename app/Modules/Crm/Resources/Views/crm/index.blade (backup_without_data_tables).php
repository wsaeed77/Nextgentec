@extends('admin.main')
@section('content')

 <section class="content-header">
    <h1>
         Customers
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Customers
        </li>
    </ol>
</section>
 
<section class="content">
  <div class="row">
            <div class="col-xs-12">
            <div id="msg"></div>
               <a href=" {{ URL::route('admin.crm.create')}}" class="btn btn-primary pull-right"> Create New Customer</a>
                @if(Auth::user()->hasRole('admin'))
               <a href="javascript:;"  onclick="import_zoho()"  class="btn btn-primary pull-left"> <i class="fa fa-download"></i> Import Zoho Customers</a>
               <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" />
               @endif
               <div class="clearfix"></div>
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Customers listing</h3>
                  <div class="box-tools">
                    <div class="input-group" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Contact</th>
                      <th>Created at</th>
                      <th>Locations</th>
                      <th>Actions</th>
                    </tr>

                    @foreach ($customers as $customer)
                            
                        <tr>
                         <td>{{ $customer->id }}.</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->main_phone }}</td>
                            <td>
                            @foreach($customer->locations as $location)
                             @foreach($location->contacts as $contact)
                              @if($contact->is_poc)
                                <button type="button" class="btn bg-gray-active  btn-sm">
                                <i class="fa fa-user"></i>  
                                    <span>{{ $contact->f_name.' '.$contact->l_name }}</span>
                                </button>  
                                 <button type="button" class="btn bg-gray-active  btn-sm">
                                  <i class="fa fa-phone"></i> 
                                    <span>{{ $contact->phone }}</span>
                                </button>
                              @endif
                             @endforeach
                            @endforeach
                            </td>
                            <td>{{ date('d/m/Y',strtotime($customer->created_at)) }}</td>
                             <td> <button type="button" class="btn bg-gray-active  btn-sm">
                                
                                   <span>{{ count($customer->locations) }}</span>
                                </button></td>
                            <td>
                            
                            <a href="{{ URL::route('admin.crm.show',$customer->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                            
                             
                             <button type="button" class="btn btn-danger btn-sm"
                                  data-toggle="modal" data-id="{{$customer->id}}" id="modaal" data-target="#modal-delete-customer">
                                    <i class="fa fa-times-circle"></i>
                                    Delete
                                </button>
                                @if(!$customer->zohoid)
                                <a href="javascript:;"  onclick="export_zoho('{{$customer->id}}')" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i>  Export to Zoho</a>
                                  <img id="load_img" src="{{asset('img/loader.gif')}}" style="display:none" />
                                @endif
                            
                            </td>
                        </tr>
                    @endforeach
                   {{--  <tr>
                      <td>183</td>
                      <td>John Doe</td>
                      <td>11-7-2014</td>
                      <td><span class="label label-success">Approved</span></td>
                      <td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
                    </tr> --}}
                   
                  </table>
                   <div class="col-xs-12">
                    {!! $customers->render() !!}
                    </div>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
</section>

 @include('crm::crm.delete_modal_ajax')
@endsection
@section('script')
 <script src="/js/jquery.dataTables.min.js"></script> 
  <script>
    function export_zoho(id)
    {
      //console.log(id);
      $('#load_img').show();
       $.get(APP_URL+'/admin/crm/ajax_customer_export_zoho/'+id,function( response ) {
              //console.log(response);
              if(response.success)
              {
                $('#msg').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
                $('#load_img').hide();
              }

              if(response.error)
              {
                $('#msg').html('<div  class="alert alert-danger"><ul><li>'+response.error_msg+'</li></ul></div>');
                $('#load_img').hide();
              }
                //$('#service_items_table').html(response.html_contents);
                },"json" 
            );
       
       alert_hide();
    }


 

    function import_zoho()
    {
      //console.log(id);
      $('#load_img_z').show();
       $.get(APP_URL+'/admin/crm/zoho_get_contacts',function( response ) {
              //console.log(response);
              if(response.success)
              {
                $('#msg').html('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>');
                $('#load_img_z').hide();
              }

              if(response.error)
              {
                $('#msg').html('<div  class="alert alert-danger"><ul><li>'+response.error_msg+'</li></ul></div>');
                $('#load_img_z').hide();
              }
                //$('#service_items_table').html(response.html_contents);
                },"json" 
            );
       
       alert_hide();
      setTimeout("location.reload(true);",10000);
    }

    $(function () {

      $('.pagination').addClass('pull-right');
    }); 

  </script>
@endsection
@section('styles')
  <link rel="stylesheet" href="{{URL::asset('css/jquery.dataTables.min.css')}}">
 
@endsection