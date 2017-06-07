@foreach($customer->locations as $location)

<div>
  <div class="row-height">
      <div class="col-md-12 col-sm-12 col-height ng-col-xl-6">
          <div class="info-box rel" id="contract-item-box" style="box-shadow: 0px 0px 1px rgba(0, 0, 0, 0.5);" data-contract-id="1" data-contract-name="Test">
						<div class="pull-right rel mr5" style="padding: 3px;">
							<a class="btn btn-default btn-xs" data-target="#modal-edit-location" data-id="{{$location->id}}" data-toggle="modal" title="Edit location">
									<i class="fa fa-pencil"></i>
							</a>
							<a class="btn btn-default btn-xs" data-target="#modal_location_delete" data-custid="{{$location->customer_id}}" data-id="{{$location->id}}" data-toggle="modal" title="Delete location">
									<i class="fa fa-trash-o"></i>
							</a>
						</div>

						@if($location->default == 1)
            <span class="hidden-xs info-box-icon abs bg-yellow">
						@else
						<span class="hidden-xs info-box-icon abs bg-light-blue-active">
						@endif
                <i class="rel b" style="top: 25%;">{{$location->location_name[0]}}</i>
                <!-- ngIf: contract.Default && contract.Active -->
            </span>
            <div class="info-box-content">
              <span class="info-box-text b">{{$location->location_name}}</span>
              <span class="info-box-text ib" style="text-transform: none;">
                  {{$location->address}}<br>
                  {{$location->city}} {{$location->state}} {{$location->zip}}
                  <!-- <span class="span-gray-light"> - Retainer/Flat Fee</span> -->
              </span>
	              <div class="pull-right" style="clear: right;">
									<i class="fa fa-phone fa-fw"></i> <a href="#call" data-dest="{{$location->phone}}" class="ctc-call-trigger">{{$location->phone}}</a><br />
									@if(!empty($location->fax))
									<i class="fa fa-fax fa-fw"></i> <a href="#call" data-dest="{{$location->fax}}" class="ctc-call-trigger">{{$location->fax}}</a>
									@endif
	              </div>
              </div>
          </div>
      </div><!-- end ngRepeat: contract in contractRow -->
  </div>
</div>
@endforeach
