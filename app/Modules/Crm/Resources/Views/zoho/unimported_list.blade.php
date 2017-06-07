@extends('admin.main')
@section('content')

@section('content_header')
    <h1>
         Unimported Customers
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i>Zoho Customers
        </li>
    </ol>
@endsection

<section class="content">
  <div class="row">
            <div class="col-xs-12">
            <div id="msg"></div>
            
             
                @role('admin')
              
               <img id="load_img_z" src="{{asset('img/loader.gif')}}" style="display:none" />
               @endrole
               <div class="clearfix"> </div>

                <div class="table-responsive">
                  <table id="dt_zoho" class="display table-striped row-border top-10px bot-10px" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Customer name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            
                        </tr>
                    </thead>
                   
                    <tbody>
                      @foreach($zoho_unimported_contacts as $contact)
                        <tr>
                          <td><input  type="checkbox" value="{{$contact->contact_id}}" class="chk"></td>
                          <td>{{$contact->contact_name}}</td>
                          <td>{{$contact->company_name}}</td>
                          <td>{{$contact->email}}</td>
                          <td>{{$contact->phone}}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                   <div class="col-xs-12">

                    </div>

                </div>

            </div>
          </div>
</section>


@endsection
@section('script')
 <!-- <script src="/js/jquery.dataTables.min.js"></script>  -->
 <script src="{{URL::asset('DataTables/datatables.min.js')}}"></script>
<script src="{{URL::asset('js/jquery.checkboxes-1.2.0.js')}}"></script>
  <script>
    $(function() {
      $('#dt_zoho').checkboxes('range', true);
     var dt_zoho = $('#dt_zoho').DataTable({
      "columns": [
          { "orderable": false },
          null,
          null,
          null,
          null
        ],
        dom: '<"col-sm-4 lr-p0"B><"img_processing"><"col-sm-5 text-center"><"col-sm-3 pull-right lr-p0"f>rt<"col-sm-3 lr-p0"l><"col-sm-4 text-center"i><"col-sm-5 pull-right lr-p0"p><"clear">',
        "order": [[ 1, "desc" ]],
        buttons: [
        {
            text: 'Select All',
            className: 'btn-sm select btn',
            action: function ( e, dt, node, config ) {
                 //assets_tbl.ajax.url( '{!! route('admin.assets.all') !!}' ).load(function() {
              $('.chk').prop('checked', true);
               //window.location = "{{ URL::route('admin.assets.create')}}";
           
                 $.each(dt_zoho.buttons('.btn'),function(ind,txt){
                    $(txt.node).addClass('unbold');
                });

                 $(dt_zoho.buttons('.select')[0].node).addClass('bold').removeClass('unbold');

                  // $('#top_heading').html('Assests');
                  
                //});
            }
           
        },
        {
            text: 'UnSelect All',
            className: 'btn-sm unselect btn',
            action: function ( e, dt, node, config ) {
                 //assets_tbl.ajax.url( '{!! route('admin.assets.all') !!}' ).load(function() {
              $('.chk').prop('checked', false);
               //window.location = "{{ URL::route('admin.assets.create')}}";
           
                 $.each(dt_zoho.buttons('.btn'),function(ind,txt){
                    $(txt.node).addClass('unbold');
                });

                 $(dt_zoho.buttons('.unselect')[0].node).addClass('bold').removeClass('unbold');

                  // $('#top_heading').html('Assests');
                  
                //});
            }
           
        },
        {
            text: 'Import',
            className: 'btn-sm import btn',
            action: function ( e, dt, node, config ) {
             
             $(".import").html('Importing Contacts...');
              $('.img_processing').html(' <img id="load_img_z" src="{{asset('img/loader.gif')}}"/>');
             
                 $.each(dt_zoho.buttons('.btn'),function(ind,txt){
                    $(txt.node).addClass('unbold');
                });

                 $(dt_zoho.buttons('.import')[0].node).addClass('bold').removeClass('unbold');

                //$('#load_img_z').show();

                var selected_ids =[];
                     $('input.chk:checkbox:checked').each(function () {
                         selected_ids .push($(this).val());
                        });

                      $.ajax({
                            url:"{{URL::route('admin.crm.import_selected')}}",
                            data:'selected_id='+selected_ids,
                            type:'post',
                            dataType:'json',
                            success:function(response)
                            {
                              //var response  = JSON.stringify(response);
                              //console.log(response.success);

                              if (response.success) {
                                $(".import").html('Success');
                                $(".import").addClass('btn-success');
                                $('#msg').html('<div  class="alert alert-success"><ul><li>' + response.success + '</li></ul></div>');
                                window.location = "{{URL::route('admin.crm.index')}}";
                                $('.img_processing').html('');
                            }

                            if (response.error) {
                                $('#msg').html('<div  class="alert alert-danger"><ul><li>' + response.error_msg + '</li></ul></div>');
                                $('.img_processing').html('');
                            }

                            }

                        });

                  
            }
           
        }
        ]
    });


    $("#checkAll").click(function(){
      $('.chk').not(this).prop('checked', this.checked);
    });
    });


  function import_zoho_contacts()
  {
     $('#load_img_z').show();

var selected_ids =[];
     $('input.chk:checkbox:checked').each(function () {
         selected_ids .push($(this).val());
        });

      $.ajax({
            url:"{{URL::route('admin.crm.import_selected')}}",
            data:'selected_id='+selected_ids,
            type:'post',
            dataType:'json',
            success:function(response)
            {
              //var response  = JSON.stringify(response);
              //console.log(response.success);

              if (response.success) {
                $('#msg').html('<div  class="alert alert-success"><ul><li>' + response.success + '</li></ul></div>');
                window.location = "{{URL::route('admin.crm.index')}}";
                $('#load_img_z').hide();
            }

            if (response.error) {
                $('#msg').html('<div  class="alert alert-danger"><ul><li>' + response.error_msg + '</li></ul></div>');
                $('#load_img_z').hide();
            }

            }

        });

  

  }


   
  </script>
@endsection
@section('styles')
  <!-- <link rel="stylesheet" href="/css/jquery.dataTables.min.css"> -->
   <link rel="stylesheet" href="{{URL::asset('DataTables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap-multiselect.css')}}">
 
@endsection
