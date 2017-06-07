					@foreach($customer->locations as $location)
                      <tr id="location_{{$location->id}}">
                          <td width="100px">
                            {{$location->location_name}}
                          </td>
                          <td>
                            @if(!empty($location->address))
                            {{$location->address}}<br>
                            {{$location->city}}, {{$location->state}} {{$location->zip}}
                            @endif
                          </td>
                          <td width="150px">{{$location->phone}}</td>
                          <td style="width: 50px; padding-right: 10px;">
                            <a class="pull-left" href="javascript:;" data-target="#modal-edit-location" id="modaal" data-id="{{$location->id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
                            <a class="pull-right" href="javascript:;" data-target="#modal-delete-loc" id="modaal" data-custid="{{$customer->id}}" data-id="{{$location->id}}" data-toggle="modal"> <i class="fa fa-times-circle"></i></a>                          
                          </td>
                      </tr>
                  @endforeach
				  