@extends('admin.main')
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                Leaves
                </h1>
                <a href=" {{ URL::route('employee.leave.create')}}" class="btn btn-primary pull-right">Post Leave</a>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/admin/dashboard">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-table"></i> Leaves
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
                                <th>Title</th>
                                
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Created at</th>
                                <th>Leave Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaves as $leave)
                            
                            
                            <tr>
                             <td>{{ $leave->title }}</td>

                                <td>{{ date('d/m/Y',strtotime($leave->start_date)) }}</td>
                                <td>{{ date('d/m/Y',strtotime($leave->end_date)) }}</td>
                                <td>{{ date('d/m/Y',strtotime($leave->created_at ))}}</td>
                                <td>{{ $leave->type }}</td>
                                <td>
                                    @if($leave->status == 'pending')
                                        <button class="btn btn-sm btn-warning" type="button">Pending</button>
                                    @elseif($leave->status == 'approved')
                                        <button class="btn btn-sm btn-success" type="button">Approved</button>
                                    @elseif($leave->status == 'rejected')
                                        <button class="btn btn-sm btn-danger" type="button">Approved</button>

                                    @endif
                                </td>
                                
                                <td>
                                
                               {{--  <a href="{{ URL::route('employee.leave.edit',$leave->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a> --}}
                                
                                 
                                 <button type="button" class="btn btn-danger btn-sm"
                                      data-toggle="modal" data-id="{{$leave->id}}" id="modaal" data-target="#modal-delete">
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
        <!-- /.row -->
        
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
</div>
@include('employee::delete_modal')
@endsection