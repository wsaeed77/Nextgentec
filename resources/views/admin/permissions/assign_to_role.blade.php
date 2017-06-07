@extends('admin.main')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                
                  Assign permissions to {{$role->display_name}}
              
                </h1>
                
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-table"></i> Permissions
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
            <div class="col-lg-6">
              
                   {!! Form::open(['url' => 'admin/torole','method'=>'POST']) !!}
                
                    <input type="hidden" name="role_id" value="{{ $role->id }}">
                   
                   
                       
                       <div class="form-group">
                                <label>Select Permissions</label>
                                <select multiple class="form-control no-gutter" id="multiselect" name="permissions[]">
                                    @foreach($permissions as $permission)
                                    <option value="{{$permission->id}}"> {{$permission->display_name}}</option>
                                    @endforeach
                                </select>
                              
                            </div>
                
                    
                    
                    
                     
                      <button type="submit" class="btn btn-lg btn-success btn-block">Add</button>
                    
                    
               
                {!! Form::close() !!}
            </div>
            
        </div>
        <!-- /.row -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>

@endsection
@section('script')
<script type="text/javascript" src="/js/multiselect.js"></script>
<script type="text/javascript">
$(document).ready(function() 
    {
        //$("#multiselect").select2( {tags: true});
        $("#multiselect").bsmSelect({
        addItemTarget: 'bottom',
        animate: true,
        highlight: true,
        
      });

    });
</script>
@endsection