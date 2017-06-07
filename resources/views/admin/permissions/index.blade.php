@extends('admin.main')
@section('content')


@section('content_header')
    <h1>
        Permissions
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Permissions
        </li>
    </ol>
@endsection

<section class="content">
    <div class="row">

        <div class="col-xs-12">
              <a href=" {{ URL::route('admin.permissions.create')}}" class="btn btn-primary pull-right"> Create New Permissions</a>
            <div class="clearfix"></div>

            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Permissions listing</h3>
                
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                <table class="table table-hover" id="dt_table">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Display Name</th>
                        <th>Name</th>
                       
                        <th>Description</th>
                        <th>Created at</th>
                       
                        <th>Actions</th>
                    </tr>
                    </thead>

                   
                  </table>
                
                    
                </div>
            </div>
        </div>
    </div>
</section>      

 @include('admin.delete_modal')
@endsection
@section('styles')
<link rel="stylesheet" href="/css/jquery.dataTables.min.css">
<style>
.col-centered{
    float: none;
    margin: 0 auto;
}
</style>
@endsection
@section('script')
 <script src="/js/jquery.dataTables.min.js"></script> 
@parent
  <script>
 $(function () {

      $('.pagination').addClass('pull-right');

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
    }); 

</script>
@endsection