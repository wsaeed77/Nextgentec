@extends('admin.main')
@section('content')


@section('content_header')
      <h1 class="page-header">
        @if(!empty($permission))
           Edit Permission
        @else
          Add New Permission
        @endif
        </h1>
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

             @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Permissions listing</h3>
                
                </div><!-- /.box-header -->
                <div class="box-body">
                       
                    <div class="col-lg-6">
                      @if(!empty($permission))
                           {!! Form::model($permission, ['route' => ['admin.permissions.update', $permission->id], 'method'=>'PUT']) !!}
                        @else
                           {!! Form::open(['route' => 'admin.permissions.store','method'=>'POST']) !!}
                        @endif
                        
                           
                            <div class="form-group">
                                <label>Name</label>
                                {!! Form::input('text','name',null, ['placeholder'=>"Name",'class'=>"form-control"]) !!}
                                <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                            </div>
                            
                            <div class="form-group">
                                <label>Display Name</label>
                                {!! Form::input('text','display_name',null, ['placeholder'=>"Display Name",'class'=>"form-control"]) !!}
                                <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                 {!! Form::input('text','description',null, ['placeholder'=>"Discription",'class'=>"form-control"]) !!}
                                <!-- <input placeholder="Password" name="password" type="password" class="form-control"> -->
                            </div>
                            
                             @if(!empty($permission))
                              <button type="submit" class="btn btn-lg btn-success btn-block">Update</button>
                             @else
                              <button type="submit" class="btn btn-lg btn-success btn-block">Add</button>
                             @endif
                            
                       
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection