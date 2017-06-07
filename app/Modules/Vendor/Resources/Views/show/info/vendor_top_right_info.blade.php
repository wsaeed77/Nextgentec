
            <div class="col-md-12 no-gutter">
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Business Hours</h3>
                 <a  data-id="{{$vendor->id}}" href="javascript:;" data-target="#modal-edit-vendor-info" class="btn btn-sm btn-primary pull-right"   data-toggle="modal"><i class="fa fa-pencil"></i> Edit</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div id="businessHoursShowDiv" class="col-md-12"></div>   
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>

            <div class="col-md-12 no-gutter" id="contacts">
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Dialing Instructions</h3>
                   <a  data-id="{{$vendor->id}}" href="javascript:;" data-target="#modal-edit-vendor-info" class="btn btn-sm btn-primary pull-right"   data-toggle="modal"><i class="fa fa-pencil"></i> Edit</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  {!! html_entity_decode($vendor->dailing_instructions) !!}
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
