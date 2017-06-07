<div class="row">
    <div class="col-lg-12">
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Effective date</th>
                        <th>Old Pay</th>
                        <th>New pay at</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee->raise as $raise)
                    
                    
                    <tr>
                        <td>{{ date('d/m/Y',strtotime($raise->effective_date)) }}</td>
                        <td>{{ $raise->old_pay }}</td>
                        <td>{{ $raise->new_pay }}</td>
                        <td>{{ $raise->notes }}</td>
                        <td>
                            
                            <!-- <a href="{{ URL::route('admin.raise.edit',$employee->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a> -->
                            
                            @if(Auth::user()->id != $employee->id)
                            <button type="button" class="btn btn-danger btn-sm"
                            data-toggle="modal" data-id="{{$raise->id}}" id="modaal" controller="raise" data-target="#modal-delete">
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
