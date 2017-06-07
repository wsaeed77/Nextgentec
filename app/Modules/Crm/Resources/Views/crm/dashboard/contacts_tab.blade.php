
@foreach($customer->locations as $location)
    @foreach($location->contacts as $contact)
      <div class="col-md-6 col-xs-12 contact-in-costumer-panel ng-col-xl-4">
      @if($contact->is_poc == 0)
        <div class="well oh contactwell">
          <div class="pull-right d" style="margin-top: 0px; margin-right: 0px;" data-toggle="tooltip" tooltip-placement="bottom" tooltip="Contact Person" data-original-title="" title="">
      @else
        <div class="well oh well-navy rel contactwell">
          <div class="pull-right d" ng-show="contact.IsContactPerson" style="margin-top: 0px; margin-right: 0px;" data-toggle="tooltip" tooltip-placement="bottom" tooltip="Contact Person" data-original-title="" title="">
      @endif
            <a class="btn btn-default btn-xs" data-target="#modal-edit-contact"  data-id="{{$contact->id}}" data-custid="{{$location->customer_id}}" data-toggle="modal" title="Edit Contact">
                <i class="fa fa-pencil"></i>
            </a>
            <a class="btn btn-default btn-xs" data-id="{{$contact->id}}" data-successid="loc_contacts_{{$location->id}}" data-locid="{{$location->id}}" data-custid="{{$location->customer_id}}"  data-target="#modal_contact_delete" data-toggle="modal" title="Delete Contact">
                <i class="fa fa-trash-o"></i>
            </a>
          </div>
          <div>
            <i class="fa fa-user fa-fw"></i> {{$contact->f_name}} {{$contact->l_name}}
          </div>
          @if(!empty($contact->title))
          <div title="Job title: {{$contact->title}}">
            <i class="fa fa-bookmark fa-fw"></i> {{$contact->title}}
          </div>
          @endif
          @if(!empty($contact->mobile))
          <div title="Cell Phone: {{$contact->mobile}}">
            <i class="fa fa-mobile-phone fa-fw"></i> <a href="#call" data-dest="{{$contact->mobile}}" class="ctc-call-trigger">{{$contact->mobile}}</a>
          </div>
          @endif
          @if(!empty($contact->phone))
          <div title="Phone: {{$contact->phone}}">
            <i class="fa fa-phone fa-fw"></i> <a href="#call" data-dest="{{$contact->phone}}" class="ctc-call-trigger">{{$contact->phone}}</a>
          </div>
          @endif
          @if(!empty($contact->email))
          <div title="Email: {{$contact->email}}" class="ellipsis">
            <i class="fa fa-at fa-fw"></i> <a href="mailto:{{$contact->email}}">{{$contact->email}}</a>
          </div>
          @endif
          <div title="Last modified: {{ date('F d, Y', strtotime($contact->updated_at)) }}">
            <i class="fa fa-calendar-check-o fa-fw"></i> {{ date('F d, Y', strtotime($contact->updated_at)) }}
          </div>
        </div>
      </div>
    @endforeach
@endforeach
