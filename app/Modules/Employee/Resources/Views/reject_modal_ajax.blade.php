
<div class="modal fade" id="modal-reject" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Please Confirm</h4>
      </div>
      <div class="modal-body">
        <p class="lead">
          <i class="fa fa-question-circle fa-lg"></i>  
          Are you sure you want to reject this Leave?
        </p>
      </div>
      <div class="modal-footer">
      <?php //$route  = 'admin.'.$controller.'.destroy';?>
       <?php /* {!! Form::open(array('route' => array($route), 'method' => 'delete')) !!} */?>
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
          <form id="reject_form">
         <input type="hidden" name="id" value="">
          <button type="button" class="btn btn-default"
                  data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger reject_ajax">
            <i class="fa fa-times-circle"></i> Yes
          </button>
          </form>
          <?php /*{!! Form::close() !!}*/?>
      </div>
    </div>
  </div>
</div>
