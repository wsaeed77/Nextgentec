
@foreach($customer->locations as $location)
    @foreach($location->contacts as $contact)

      <tr id="loc_contacts_{{$contact->id}}">
        <td style="width: 175px;">
          <a  class="pull-left" href="javascript:;" data-target="#modal-edit-contact"  data-id="{{$contact->id}}" data-custid="{{$location->customer_id}}" data-toggle="modal">{{$contact->f_name}} {{$contact->l_name}}</a><br />
          @if(!empty($contact->title))
          {{$contact->title}}<br />
          @endif
          {{$location->location_name}}
        </td>
        <td>
          {{$contact->email}}
        </td>
        <td style="width: 150px; text-align: right;">
          @if(!empty($contact->phone))
          <i class="fa fa-phone" style="color: #969696; text-shadow: 1px 1px 1px #ccc; margin-right: 5px;"></i>  <a href="#call" data-dest="{{$contact->phone}}" class="ctc-call-trigger">{{$contact->phone}}</a><br />
          @endif
          @if(!empty($contact->mobile))
          <i class="fa fa-mobile" style="color: #969696; text-shadow: 1px 1px 1px #ccc; margin-right: 5px;"></i>  <a href="#call" data-dest="{{$contact->mobile}}" class="ctc-call-trigger">{{$contact->mobile}}</a>
          @endif
        </td>
        <td style="width:10px;">
          <a class="pull-right" href="javascript:;"  data-id="{{$contact->id}}" data-successid="loc_contacts_{{$location->id}}" data-locid="{{$location->id}}" data-custid="{{$customer->id}}"  data-target="#modal-delete-cntct" data-toggle="modal" ><i class="fa fa-times-circle"></i></a>
        </td>
      {{-- <td>
        <div class="progress progress-xs">
          <div style="width: 55%" class="progress-bar progress-bar-danger"></div>
        </div>
      </td>
      <td><span class="badge bg-red">55%</span></td> --}}
    </tr>
    @endforeach
@endforeach
