<!-- Widget: user widget style 1 -->
<!-- Add the bg color to the header using any of the bg-* classes -->
<div class="widget-user-header bg-yellow">
  <!-- /.widget-user-image -->
  <h3 class="widget-user-username">{{$vendor->name}}</h3>
  <button type="button" class="btn btn-danger btn-sm pull-right"
                              data-toggle="modal" data-id="{{$vendor->id}}" id="modaal" data-target="#modal-delete-vendor">
                                <i class="fa fa-times-circle"></i>
                                Delete
                            </button>
</div>
<div class="box-footer no-padding">
  <ul class="nav nav-stacked">
    @if(!empty($vendor->phone_number))
    <li><a  data-id="{{$vendor->id}}" href="javascript:;" data-target="#modal-edit-vendor-info"   data-toggle="modal">Phone<span class="pull-right">{{ $vendor->phone_number}}</span></a></li>
    @endif

     @if(!empty($vendor->website))
    <li><a  data-id="{{$vendor->id}}" href="javascript:;" data-target="#modal-edit-vendor-info"   data-toggle="modal"> Website <span class="pull-right">{{ $vendor->website}}</span></a></li>
    @endif


     @if(!empty($vendor->city))
    <li><a  data-id="{{$vendor->id}}" href="javascript:;" data-target="#modal-edit-vendor-info"   data-toggle="modal">City <span class="pull-right">{{ $vendor->city}}</span></a></li>
    @endif


     @if(!empty($vendor->state))
    <li><a  data-id="{{$vendor->id}}" href="javascript:;" data-target="#modal-edit-vendor-info"   data-toggle="modal">State <span class="pull-right">{{ $vendor->state}}</span></a></li>
    @endif


     @if(!empty($vendor->zip))
    <li><a  data-id="{{$vendor->id}}" href="javascript:;" data-target="#modal-edit-vendor-info"   data-toggle="modal">Zip <span class="pull-right">{{ $vendor->zip}}</span></a></li>
    @endif
      @if(!empty($vendor->address))
    <li><a  data-id="{{$vendor->id}}" href="javascript:;" data-target="#modal-edit-vendor-info"   data-toggle="modal">Address <span class="pull-right">{{ $vendor->address}}</span></a></li>
    @endif


  </ul>
</div>
<!-- /.widget-user -->
