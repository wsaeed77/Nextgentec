 @extends('admin.main')
@section('content')

 @section('content_header')
    <h1>
         File Manager
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Customers
        </li>
    </ol>
@endsection

<section class="content">
  <div class="row">
         <div id="filemanager1" class="filemanager"></div>


    </div>
</section>
@endsection
@section('script')
  <script  src="{{URL::asset('filemanager/js/filemanager-ui-without.js')}}"></script>
@endsection

@section('document.ready')

  var fm = $("#filemanager1").filemanager({
              url:'{{url("/")}}/admin/crm/filemanager/connection',
             //path:"{{$folder}}",
              languaje: "us",
              upload_max: 7,
              views:'details',
              //insertButton:true,
              token:"{{csrf_token()}}",
              context_menu_items:'<li class="publicurl" style="display: block;"><a href="#">Public URL</a></li>'
          });
@endsection

@section('styles')
<link rel="stylesheet" href="{{URL::asset('filemanager/css/filemanager-ui.css')}}">
<style>
.filemanager .form-control-textarea {
    color: #000;
    height: auto;
    padding: 5px 10px;
}
.menu_contextual li.publicurl a::before {
    content: "";
}
</style>
@endsection
