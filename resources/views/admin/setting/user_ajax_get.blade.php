  <div class="box-body table-responsive">
      <table class="table table-hover" id="dt_table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
           
            <th>Created at</th>
             <th>Mobile</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{$user->id}}</td>
              <td>{{$user->f_name.' '.$user->l_name}}</td>
              <td>{{$user->phone}}</td>
              <td>{{ date('d/m/Y',strtotime($user->created_at)) }}</td>
              <td>{{$user->mobile}}</td>
              <td>{{$user->email}}</td>
              <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="{{$user->id}}" id="modaal" data-target="#modal-edit-user">
                       <i class="fa fa-pencil"></i>Edit</button>
              </td>
            </tr>
          </tbody>
     
      </table>
    </div>