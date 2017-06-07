                  @foreach($customer->locations as $location)
                  @foreach($location->contacts as $contact)
                    <tr id="loc_contacts_{{$contact->id}}">
                        <td width="200">
                          <b>{{$contact->f_name}} {{$contact->l_name}}</b> <br/>
                          {{$location->location_name}}
                        </td>
                        <td width="245" style="text-align:left;">
                          <i class="fa fa-envelope-o" style="width: 20px; padding-right: 5px;"></i> <a href="mailto:{{$contact->email}}">{{$contact->email}}</a> <br/>
                          <i class="fa fa-phone" style="width: 20px; padding-right: 5px;"></i>  {{$contact->phone}} <br/>
                          <i class="fa fa-mobile" style="width: 20px; padding-right: 5px;"></i> {{$contact->mobile}}</td>
                        </td>                                                
                        <td style="width: 50px; padding-right: 10px;">
                          <a class="pull-left" href="javascript:;" data-target="#modal-edit-contact"  data-id="{{$contact->id}}" data-custid="{{$location->customer_id}}" data-toggle="modal"><i class="fa fa-pencil"></i></a>
                          <a class="pull-right" href="javascript:;"  data-id="{{$contact->id}}" data-successid="loc_contacts_{{$location->id}}" data-locid="{{$location->id}}" data-custid="{{$customer->id}}"  data-target="#modal-delete-cntct" data-toggle="modal" ><i class="fa fa-times-circle"></i></a>
                        </td>
                    </tr>
                @endforeach
                @endforeach