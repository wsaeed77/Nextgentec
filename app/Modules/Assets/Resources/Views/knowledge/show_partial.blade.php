@if($type=='procedure')
<div class="col-lg-12">

  <div class="col-lg-4">
        <strong><i class="fa fa-user margin-r-5"></i>  Customer</strong>
        <p class="text-muted">
            <button class="btn bg-gray-active  btn-sm" type="button">
              <i class="fa fa-user"></i>
                  <span>{{$procedure->customer->name}}</span>
              </button>

        </p>
  </div>

  <div class="col-lg-4">
    <strong> Title</strong>
    <p class="text-muted">{{$procedure->title}}</p>
  </div>

 
<div class="clearfix"></div>
<hr>
</div>
<div class="col-lg-12">

        <strong><i class="fa fa-file-text-o margin-r-5"></i> Procedure</strong>

        <p>{!! html_entity_decode($procedure->procedure) !!}</p>

        <div class="clearfix"></div>


  </div>
  @endif

@if($type=='serial_number')
<div class="col-lg-12">

  <div class="col-lg-4">
        <strong><i class="fa fa-user margin-r-5"></i>  Customer</strong>
        <p class="text-muted">
            <button class="btn bg-gray-active  btn-sm" type="button">
              <i class="fa fa-user"></i>
                  <span>{{$serial_number->customer->name}}</span>
              </button>

        </p>
  </div>

  <div class="col-lg-4">
    <strong> Title</strong>
    <p class="text-muted">{{$serial_number->title}}</p>
  </div>

  <div class="col-lg-4">
    <strong> Serial #</strong>
    <p class="text-muted">{{$serial_number->serial_number}}</p>
  </div>
<div class="clearfix"></div>
<hr>
</div>
<div class="col-lg-12">

        <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

        <p>{!! html_entity_decode($serial_number->notes) !!}</p>

        <div class="clearfix"></div>


  </div>
  @endif


  <div class="clearfix"></div>
