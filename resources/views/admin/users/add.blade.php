@extends('admin.main')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                @if(!empty($user))
                   Edit User
                @else
                  Add New User
                @endif
                </h1>
                
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
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

             @if(!empty($user))
                   {!! Form::model($user, ['route' => ['admin.user.update', $user->id], 'method'=>'PUT']) !!}
                @else
                   {!! Form::open(['route' => 'admin.user.store','method'=>'POST']) !!}
                @endif
            <div class="col-lg-12">
                <div class="page-header">
                    <h3>Personal Info</h3>
                </div>
            </div>
            <div class="col-lg-1">
            </div>
            <div class="col-lg-5">
             
                   
                    <div class="form-group">
                        <label>First Name</label>
                        {!! Form::input('text','f_name',null, ['placeholder'=>"First Name",'class'=>"form-control"]) !!}
                        <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                    </div>
                     <div class="form-group">
                        <label>Last Name</label>
                        {!! Form::input('text','l_name',null, ['placeholder'=>"Last Name",'class'=>"form-control"]) !!}
                        <!-- <input placeholder="Name" type="text" name="name"  value="{{ old('name') }}" > -->
                    </div>
                    
                    <div class="form-group">
                        <label>Email</label>
                        {!! Form::email('email',null, ['placeholder'=>"Email",'class'=>"form-control"]) !!}
                        <!-- <input placeholder="Email" type="text" name="email" value="{{ old('email') }}" class="form-control"> -->
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                         {!! Form::password('password', ['placeholder'=>"Password",'class'=>"form-control"]) !!}
                        <!-- <input placeholder="Password" name="password" type="password" class="form-control"> -->
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        {!! Form::password('password_confirmation', ['placeholder'=>"Confirm Password",'class'=>"form-control"]) !!}
                        <!-- <input placeholder="Confirm Password" name="password_confirmation" type="password"  class="form-control"> -->
                    </div>
                    <div class="form-group">
                        <label>Select Roles</label>
                    
                            <select class="form-control" id="multiselect" name="role">
                             <option value="" > Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" 
                                        @if(isset($user_role) && ($user_role==$role->id))
                                     <?php echo 'selected="selected"';?> @endif> {{$role->display_name}}</option>
                                @endforeach
                            </select>
                              
                    
                    </div>
                     @if(!empty($user))
                      <button type="submit" class="btn btn-lg btn-success btn-block">Update</button>
                     @else
                      <button type="submit" class="btn btn-lg btn-success btn-block">Add</button>
                     @endif
                    
               
                
            </div>
             
            {!! Form::close() !!}
        </div>
        <!-- /.row -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>

@endsection
@section('script')

<script type="text/javascript">
$(document).ready(function() 
    {
       
        
    });
</script>
@endsection