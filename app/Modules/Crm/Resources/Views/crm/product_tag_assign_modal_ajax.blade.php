<div class="modal fade" id="modal-product-tag-assign" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Assign Products</h4>
      </div>
      <div class="modal-body">               
          <div id="err_p_tag">
          </div>    
        <form id="assign_p_tag">                 
         <div class="form-group col-lg-6">
              <label>Products</label>
            {!! Form::select('products[]', $products,$assigned_products,['class'=>'form-control multiselect','placeholder' => 'Assign products', 'id'=>'products','multiple'=>''])!!}
              <input type="hidden"  name="customer_id_for_tag" value="{{$customer->id}}">        
          </div>
      
         
        </form>
        <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
          <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
      
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_product_tag">Close</button>
          <button  class="btn btn-primary new_product_tag">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>


@section('document.ready')
@parent
$('#modal-product-tag-assign').on('show.bs.modal', function(e) 
      {

          $('#err_p_tag').html('');
          //$(this).find(':input').val('');

      });

       $( ".new_product_tag" ).click(function() {

         $.ajax({
                url: "{{ URL::route('admin.crm.ajax.add_p_tag')}}",
                type: 'POST',
                dataType: 'json',
                data: $('#assign_p_tag').serialize(),
                success: function(response){
                if(response.success =='ok')
                {
                    window.location.reload();
                     
                   
                }
                
                },
                error: function(data){
                    var errors = data.responseJSON;
                    //console.log(errors);
                    var html_error = '<div  class="alert alert-danger"><ul>';
                    $.each(errors, function (key, value) 
                    {
                        html_error +='<li>'+value+'</li>';
                    })
                     html_error += "</ul></div>";
                $('#err_p_tag').html(html_error);
               
              }
            });
      
          });

   
@endsection
