
 @foreach($service_items as $service_item)
    <tr id="service_item_data_{{$service_item->id}}">

    <td>{{$service_item->title}}</td>
        <td>{{$service_item->service_type->title}}</td>
        <td>{{ date('d/m/Y',strtotime($service_item->start_date)) }}</td>
        <td>{{ date('d/m/Y',strtotime($service_item->end_date)) }}</td>
        
        
        <td>
        <a  class="btn btn-default btn-sm " data-srvcitemid="{{$service_item->id}}" href="javascript:;" data-target="#modal-add-new-rate"   data-toggle="modal"><i class="fa fa-plus"></i> Add New Rate</a>
            <a class="btn btn-sm btn-primary" href="javascript:;" data-target="#modal-edit-service-item" id="modaal" data-id="{{$service_item->id}}"  data-servicetid="{{$service_item->service_type_id}}" 
             data-toggle="modal"><i class="fa fa-pencil"></i> Edit</a>
            <button data-target="#modal-delete-sitem" id="modaal" data-id="{{$service_item->id}}" data-toggle="modal" data-custid="{{$customer_id}}" class="btn btn-danger btn-sm" type="button">
            <i class="fa fa-times-circle"></i>
            Delete
            </button>
        </td>
    </tr>
@endforeach