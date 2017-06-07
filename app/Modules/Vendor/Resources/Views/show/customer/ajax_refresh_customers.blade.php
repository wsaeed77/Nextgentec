
 @foreach($vendor->customers as $customer)
 
    <tr id="customer_{{$customer->pivot->id}}">

    <td> <button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>{{$customer->name}}</span>
                            </button>
                            @if($customer->location)
                            <button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>{{$customer->location->name}}</span>
                            </button>
                            @endif
                            </td>
    <td>{{$customer->pivot->auth_contact_name}}</td>
    <td>{{$customer->pivot->phone_number}} </td>
    <td>{{$customer->pivot->account_number}} </td>
    <td>{{$customer->pivot->portal_username}} </td>
    <td>{{$customer->pivot->portal_password}} </td>
    <td>{{ date($date_format->key,strtotime($customer->pivot->created_at)) }}</td>
           
    <td>
        
            <a class="btn btn-sm btn-primary" href="javascript:;" data-target="#modal-edit-customer" id="modaal" data-id="{{$customer->pivot->id}}"  data-vendor_id="{{$vendor->id}}" data-toggle="modal"><i class="fa fa-pencil"></i> Edit</a>
            <button data-target="#modal-delete-customer" id="modaal" data-id="{{$customer->pivot->id}}" data-toggle="modal"  class="btn btn-danger btn-sm" type="button">
            <i class="fa fa-times-circle"></i>
            Delete
            </button>
        </td>
    </tr>
@endforeach