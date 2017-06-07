<!-- MARCEL's Global Parial View for Delete Dialog -->

<div class="modal fade" id="{{$id}}" tabIndex="-1">
  <div class="modal-dialog modal-narrow">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Record</h4>
      </div>
      <div class="modal-body">
      <div id="msg_del"></div>
        <p>{{$message}}</p>
      </div>
      <div class="modal-footer">
        {!! Form::open(['method' => 'post','id'=>$id.'_form']) !!}
        <input type="hidden" name="id" value="">
        <button type="button" class="btn btn-sm btn-danger pull-left" id="delete_btn">Delete</button>
        <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button>
        {!! Form::close() !!}
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@section('script')
@parent
  <script type="text/javascript">
    $(document).ready(function() {
      var del_cust_id = '';

      $('#{{$id}}').on('show.bs.modal', function(e) {
        //get data-id attribute of the clicked element
        var Id = $(e.relatedTarget).data('id');
        del_cust_id = Id;
        $(e.currentTarget).find('input[name="id"]').val(Id);
      });

       $('#{{$id}}').on('hide.bs.modal', function(e) {
        $('#msg_del').html('');
      });

      $('#{{$id}} #delete_btn').click(function() {
         $.ajax({
         url: "{{ URL::route($url)}}",
         type: 'POST',
         dataType: 'json',
         data:$('#{{$id.'_form'}}').serialize() ,
         success: function(response){
           if(response.success) {
             @if($refresh)
              $('#{{$id}}').modal('hide');
              setTimeout(location.reload.bind(location), 500);
             @endif
           }
           if(response.error)
           {
              $('#msg_del').html('<div  class="alert alert-danger"><li>'+response.error+'</li></ul>');
              //$('#msg_del').css('color','red');
              alert_hide();

              setTimeout(function(){$('#{{$id}}').modal('hide')}, 5000);
              
           }
           @if(@$callBackFunction)
              setTimeout(function(){$('#{{$id}}').modal('hide')}, 200);
              {{$callBackFunction}}
           @endif
         }
        });
      });
    });
  </script>
@endsection

@section('styles')
@parent
<style>
.modal-narrow {
  width: 400px !important;
}
</style>
@endsection
