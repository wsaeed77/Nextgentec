
 @foreach($service_items as $service_item)
   @foreach($service_item->rates as $rate)
    <tr id="service_item_rates_{{$service_item->id}}">
        <td>{{$rate->title}}</td>
        <td> @if($rate->status)
                 <span class="badge btn-success">Active</span>
            @else
                <span class="badge">No</span>
            @endif 
        </td>
        <td>{{$service_item->service_type->title}}</td>
        <td>$ {{$rate->amount}}</td>
        <td>
        @if($rate->is_default)
         <span class="badge btn-success">Yes</span>
        
         @else
                <span class="badge">No</span>
            @endif 
        
        <td>
            <a  class="btn btn-primary btn-sm" href="javascript:;" data-target="#modal-edit-rate"  data-id="{{$rate->id}}" data-srcitmid="{{$service_item->id}}" data-toggle="modal"><i class="fa fa-pencil"></i> Edit</a>
            <a href="javascript:;" class="btn btn-sm btn-danger" data-target="#modal-delete-rate"  data-id="{{$rate->id}}" data-sid="{{$service_item->id}}" data-toggle="modal"><i class="fa fa-times-circle"></i> Delete</a>
        </td>
    </tr>
@endforeach
@endforeach