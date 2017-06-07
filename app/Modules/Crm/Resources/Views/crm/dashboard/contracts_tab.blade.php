<div class="row">
    <div class="col-lg-12" >
        <div class="box" id="service_items_panel">
        <div class="box-header">
          <h3 class="box-title">Service Items</h3>
          <div class="box-tools">
           <div style="width: 150px;" class="input-group">
           <a  class="btn btn-default btn-sm pull-right" data-custid="{{$customer->id}}" href="javascript:;" data-target="#modal-add-new-service-item"  data-toggle="modal"><i class="fa fa-plus"></i> Add New Service Item</a>


            </div>
          </div>
        </div><!-- /.box-header -->

        <div class="box-body table-responsive ">
          <table class="table table-hover">
            <tr>
              <th>Title</th>
              <th>Type</th>
              <th>Start Date</th>

              <th>End Date</th>
              <th>Action</th>
            </tr>
             <tbody id="service_items_table">

              </tbody>
          </table>
        </div><!-- /.box-body -->
      </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12" >
        <div class="box" id="rates_panel">
        <div class="box-header">
          <h3 class="box-title">Rates</h3>

        </div><!-- /.box-header -->

        <div class="box-body table-responsive ">
          <table class="table table-hover">
           <tr>
                <th>Title</th>

                <th>Active?</th>
                <th>Service item</th>
                <th>Amount</th>

                <th>Is Default?</th>
                <th>Action</th>
            </tr>
             <tbody id="rates_table">

             </tbody>
          </table>
        </div><!-- /.box-body -->
      </div>
    </div>
</div>
