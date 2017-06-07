@foreach($locations as $location)

<tr id="location_{{$location->id}}">
	<td style="width: 175px;">
		<a class="pull-left" href="javascript:;" data-target="#modal-edit-location" id="modaal" data-id="{{$location->id}}" data-toggle="modal">{{$location->location_name}}</i></a>
	</td>
	<td>
		<a href="http://maps.google.com/?q={{urlencode($location->address.' '.$location->city.' '.$location->state.' '.$location->zip)}}" target="_blank" title="View on Google Maps">{{$location->address}}<br />
		{{$location->city}} {{$location->state}} {{$location->zip}}</a>
	</td>
	<td style="width: 150px; text-align: right;">
		<i class="fa fa-phone" style="color: #969696; text-shadow: 1px 1px 1px #ccc; margin-right: 5px;"></i> <a href="#call" data-dest="{{$location->phone}}" class="loc-call-trigger">{{$location->phone}}</a><br />
		@if(!empty($location->fax))
		<i class="fa fa-fax" style="color: #969696; text-shadow: 1px 1px 1px #ccc; margin-right: 5px;"></i> <a href="#call" data-dest="{{$location->fax}}" class="loc-call-trigger">{{$location->fax}}</a>
		@endif
	</td>
	<td style="width:10px;">
	    <a class="pull-right" href="javascript:;" data-target="#modal-delete-loc" id="modaal" data-custid="{{$customer_id}}" data-id="{{$location->id}}" data-toggle="modal"> <i class="fa fa-times-circle"></i></a>
	</td>
</tr>

@endforeach
