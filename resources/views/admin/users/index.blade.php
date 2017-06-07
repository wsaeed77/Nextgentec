@extends('admin.main')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                Users
                </h1>
                <a href=" {{ URL::route('admin.user.create')}}" class="btn btn-primary pull-right"> Create User</a>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-table"></i> Users
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
            <div class="col-lg-12">
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            
                            
                            <tr>
                                <td>{{ $user->f_name }} {{ $user->l_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                
                                <a href="{{ URL::route('admin.user.edit',$user->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                
                                 @if(Auth::user()->id != $user->id)
                                 <button type="button" class="btn btn-danger btn-sm"
                                      data-toggle="modal" data-id="{{$user->id}}" id="modaal" data-target="#modal-delete">
                                        <i class="fa fa-times-circle"></i>
                                        Delete
                                    </button>
                                 @endif  
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        <!-- /.row -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
@include('admin.delete_modal')
@endsection