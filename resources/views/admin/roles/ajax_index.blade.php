
                <div class="table-responsive">
                
                 <button type="button" class="btn btn-primary btn-sm pull-right" id="modaal"  data-toggle="modal" data-target="#modal-create-role" class="btn btn-primary pull-right"> Create New Role</button>
                     <table class="table table-hover padding-top-10" id="roles">
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
                                <td>{{ date($global_date,strtotime($role->created_at)) }}</td>
                                <td>
                                        
                                        
                                         <button type="button" class="btn btn-sm btn-primary"
                                              data-toggle="modal" data-id="{{$role->id}}" id="modaal" data-target="#modal-edit-role">
                                        <i class="fa fa-pencil"></i> Edit
                                      </button>
                                        <!-- <button type="submit" class="btn btn-xs btn-danger">Delete</button> -->
                                        <button type="button" class="btn btn-danger btn-sm"
                                              data-toggle="modal" data-id="{{$role->id}}" id="modaal" data-target="#modal-delete-role">
                                        <i class="fa fa-times-circle"></i>
                                        Delete
                                      </button>
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
          



