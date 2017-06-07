@extends('admin.main')
@section('content')


@section('content_header')
<h1>
     Employees
</h1>
<ol class="breadcrumb">
    <li>
        <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
    </li>
    <li class="active">
        <i class="fa fa-table"></i> Employees
    </li>
</ol>
@endsection
<section class="content">
  <div class="row">
    <div class="col-xs-12">
    <a href=" {{ URL::route('admin.employee.create')}}" class="btn btn-default btn-xs pull-right">Add Employee</a>
                <div class="clearfix"></div>

                  <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>

                                    <th>Created at</th>
                                     <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)


                                <tr>
                                    <td>{{ $employee->f_name }} {{ $employee->l_name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ date('d/m/Y',strtotime($employee->created_at)) }}</td>
                                    <td><?php if($employee->roles)
                                                {
                                                    foreach( $employee->roles as $role )
                                                    {
                                                    echo $role->display_name;
                                                    //dd($role->display_name);
                                                    }
                                                }?>
                                    </td>
                                    <td>
                                     <a href="{{ URL::route('admin.employee.show',$employee->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Show</a>
                                    <a href="{{ URL::route('admin.employee.edit',$employee->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>

                                     @if(Auth::user()->id != $employee->id)
                                     <button type="button" class="btn btn-danger btn-sm"
                                          data-toggle="modal" data-id="{{$employee->id}}" id="modaal" data-target="#modal-delete">
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
</section>

@include('employee::delete_modal')
@endsection
