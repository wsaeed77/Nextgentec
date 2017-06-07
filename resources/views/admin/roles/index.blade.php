@extends('admin.main')
@section('content')
<?php //echo Route::currentRouteName();?>


@section('content_header')
    <h1>
        Roles
        {{-- <small>preview of simple tables</small> --}}
    </h1>
    <ol class="breadcrumb">
        <li>
            <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
        </li>
        <li class="active">
            <i class="fa fa-table"></i> Roles
        </li>
    </ol>
@endsection
<section class="content">
    <div class="row">

        <div class="col-xs-12">
           <a href=" {{ URL::route('admin.role.create')}}" class="btn btn-primary pull-right"> Create New Role</a>
            <div class="clearfix"></div>

            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Roles listing</h3>
                
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                     <table class="table table-hover" id="roles">
                        <thead>
                           <tr>
                                <th>Display Name</th>
                                <th>Name</th>
                               
                                <th>Description</th>
                                <th>Created at</th>
                               
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            
                            
                            <tr>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->name }}</td>
                                
                                <td>{{ $role->description }}</td>
                                <td>{{ date('d/m/Y',strtotime($role->created_at)) }}</td>
                                <td>
                                        
                                        <a href="{{ URL::route('admin.role.edit',$role->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                        <!-- <button type="submit" class="btn btn-xs btn-danger">Delete</button> -->
                                        <button type="button" class="btn btn-danger btn-sm"
                                              data-toggle="modal" data-id="{{$role->id}}" id="modaal" data-target="#modal-delete">
                                        <i class="fa fa-times-circle"></i>
                                        Delete
                                      </button>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>        

 @include('admin.delete_modal')
@endsection
