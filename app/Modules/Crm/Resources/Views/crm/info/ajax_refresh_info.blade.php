<!-- Widget: user widget style 1 -->
<!-- Add the bg color to the header using any of the bg-* classes -->
<div class="widget-user-header bg-yellow">
  <!-- /.widget-user-image -->
  <h3 class="widget-user-username">{{$customer->name}}</h3>
  <h5 class="widget-user-desc">{{ date('F Y',strtotime($customer->customer_since)) }}</h5>
</div>
<div class="box-footer no-padding">
  <ul class="nav nav-stacked">
    @if(!empty($customer->email_domain))
    <li><a  data-id="{{$customer->id}}" href="javascript:;" data-target="#modal-edit-customer-info"   data-toggle="modal">Email Domain <span class="pull-right">{{ $customer->email_domain}}</span></a></li>
    @endif
    <li>
      <a  data-id="{{$customer->id}}" href="javascript:;" data-target="#modal-edit-customer-info"   data-toggle="modal">
        Primary Phone
        <span class="pull-right">
            @foreach($customer->locations as $location)
                @if($location->default)
                  {{$location->phone}}
                @endif
            @endforeach
        </span>
      </a>
    </li>
    <li><a  data-id="{{$customer->id}}" href="javascript:;" data-target="#modal-edit-customer-info"   data-toggle="modal">Taxable
    @if($customer->is_taxable)
        <span class="pull-right badge bg-green">Yes</span>
    @else
        <span class="pull-right badge bg-red">No</span>
    @endif
    </a></li>
    <li><a  data-id="{{$customer->id}}" href="javascript:;" data-target="#modal-edit-customer-info"   data-toggle="modal">Active
    @if($customer->is_active)
          <span class="pull-right badge bg-green">Yes</span>
    @else
        <span class="pull-right badge bg-red">No</span>
    @endif
    </a></li>
  </ul>
</div>
<!-- /.widget-user -->
