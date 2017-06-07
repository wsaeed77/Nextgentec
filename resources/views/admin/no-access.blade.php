@extends('admin.main')
@section('content')


@section('content_header')
    <h1>
         403 Access denied
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> 403
        </li>
    </ol>
@endsection
        <section class="content">
          <div class="error-page">
            <h2 class="headline text-yellow"> 403</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> Oops! You don't have access to this area.</h3>
              <p>
                You have limited permissions to access this page.
                Meanwhile, you may <a href="/admin/dashboard">return to dashboard</a>
              </p>
            
            </div><!-- /.error-content -->
          </div><!-- /.error-page -->
        </section><!-- /.content -->
     @endsection