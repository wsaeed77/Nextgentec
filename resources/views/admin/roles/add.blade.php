@extends('admin.main')

@section('content_header')
    <h1>
       @if(!empty($role))
           Edit Role
        @else
          Add New Role
        @endif
    </h1>
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
@section('content')



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
                  <h3 class="box-title">Roles listing</h3>
                
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-lg-6">
                          @if(!empty($role))
                               {!! Form::model($role, ['route' => ['admin.role.update', $role->id], 'method'=>'PUT']) !!}
                            @else
                               {!! Form::open(['route' => 'admin.role.store','method'=>'POST']) !!}
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

                                <div class="form-group">
                                    <label>Select Permissions</label>
                                    
                                        <select multiple class="form-control" id="multiselect" name="permissions[]">
                                            @foreach($permissions as $permission)
                                                <option value="{{$permission->id}}" 
                                                    @if(isset($selected_perms) && in_array($permission->id,$selected_perms))
                                                 <?php echo 'selected="selected"';?> @endif> {{$permission->display_name}}</option>
                                            @endforeach
                                        </select>
                                             
                                
                                </div>
                            
                                 @if(!empty($role))
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
@section('script')

<script type="text/javascript">
$(document).ready(function() 
    {
        $('#multiselect').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,
            maxHeight: 400,
            dropUp: false,
            buttonClass: 'form-control',
            onChange: function(option, checked, select) {
                //alert($('#multiselect').val());
            }
        });
        
    });
</script>
@endsection
@section('styles')
<link href="/css/bootstrap-multiselect.css" rel="stylesheet" />
@endsection