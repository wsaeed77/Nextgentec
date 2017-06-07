<div class="modal fade" id="modal-create-admin-leave" tabIndex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Post leave</h4>
      </div>
      <div class="modal-body">               
          <div id="error_leave_for_employee">
          </div>    
        <form id="create_leave_for_employee">
                   <input type="hidden" value="{{$employee->id}}" name="employee_id">
                    <div class="col-lg-12"> 
                      <div class="form-group col-lg-6">
                        <label>Leave Type</label>
                        <?php $categories = ['full'=>'Full',
                                            'short'=>'Short'];
                                            ?>
                       {!! Form::select('category', $categories,'',['class'=>'form-control multiselect','placeholder' => 'Pick leave type','onchange'=>'show_duration(this.value)'])!!}
                      </div>

                      <div class="form-group col-lg-6" id="date_range_div" style="display: none">
                            <label>Leaves duration</label>
                            <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                            {!! Form::input('text','duration',null, ['placeholder'=>"Duration",'id'=>'duration_full','class'=>"form-control"]) !!}
                            
                             </div>
                        </div>

                        <div class="form-group col-lg-6" id="time_div" style="display: none">
                            <label>Duration</label>
                             <?php
                            
                            $duration = [];
                             for($h=1; $h<=4;$h++) {
                            
                               for($m=0; $m<=45;$m=$m+15) {
                                  if($m==0)
                                  {
                                    $m="00";
                                  }
                                 $duration[$h.'.'.(($m*100)/60)] = '0'.$h.':'.$m.' Hours';
                                 
                                 if($h==4)
                                  break;

                               }

                             }
                          ?>
                           {!! Form::select('duration_short', $duration,'',['class'=>'form-control multiselect','placeholder' => 'leave duration'])!!}
                        </div>

                         <div class="form-group col-lg-6" id="short_date_div" style="display: none">
                        <label>Leave date</label>
                          {!! Form::input('text','date',null, ['placeholder'=>"Leave date",'class'=>"form-control",'data-date-format'=>$js_global_date,'id'=>'date_short_leave']) !!}
                        </div>

                           <div class="form-group col-lg-6">
                            <label>Leave Category</label>
                            <?php $types = ['annual'=>'Annual',
                                                'sick'=>'Sick'];
                                                ?>
                           {!! Form::select('type', $types,'',['class'=>'form-control multiselect','placeholder' => 'Pick leave category'])!!}
                          </div>
                  


                        @ability('', 'post_leave_for_employee,approve_leave')
                          <input type="hidden" value="{{$employee->id}}" name="posted_for">
                          <input type="hidden" value="{{Auth::user()->id}}" name="posted_by">
                          <div class="form-group col-lg-6">
                            <label>Status</label>
                            <?php $status = ['approved'=>'Approved',
                                                'rejected'=>'Rejected',
                                                'pending' => 'Pending'];
                                                ?>
                           {!! Form::select('status', $status,'',['class'=>'form-control multiselect','placeholder' => 'Pick leave status'])!!}
                          </div>
                          
                        @endability

                            <div class="form-group col-lg-6">
                                  <label>Poster Comments</label>
                                  {!! Form::textarea('poster_comments',null, ['placeholder'=>"Comments",'class'=>"form-control",'rows'=>2]) !!}
                              </div>

                        @ability('', 'post_leave_for_employee,approve_leave')
                           <div class="form-group col-lg-6">
                                <label>Approver Comments</label>
                                {!! Form::textarea('approver_comments',null, ['placeholder'=>"Comments",'class'=>"form-control",'rows'=>2]) !!}
                            </div>

                         @endability
                        
                        

                      
                       {{--  <div class="form-group col-lg-6">
                            <label>Title</label>
                            {!! Form::input('text','title',null, ['placeholder'=>"Title",'class'=>"form-control"]) !!}
                        </div> --}}
                  
                   
                    </div>
                    
                          
                    
               
           </form>
           <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
      <?php //$route  = $route;?>
      
        
       
         
          <button type="button" class="btn btn-default"
                  data-dismiss="modal" id="close_leave_post_for_employee">Close</button>
          <button  class="btn btn-primary " id="new_leave_post_for_employee">
             Save
          </button>
      
      </div>
    </div>
  </div>
</div>

@section('document.ready')
@parent


$('#modal-create-admin-leave').on('hide.bs.modal', function(e) 
      {

         // $('#err_status').html('');
           //$(this).find(':input').val('');
           $(this).removeData('bs.modal');

      });

       $( "#new_leave_post_for_employee" ).click(function() {
          $('#hidden_duration').val($('#duration_full').val());
         $.ajax({
                url: "{{ URL::route('admin.leave.post_leave_for_employee')}}",
                //headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: $('#create_leave_for_employee').serialize(),
                success: function(response){
                if(response.success)
                {
                      $( "#close_leave_post_for_employee" ).trigger( "click" );
                      $('<div  class="alert alert-success"><ul><li>'+response.success+'</li></ul></div>').insertBefore($('#dt_leaves_table').parent());
                      
                   var  table = $('#dt_leaves_table').DataTable( {
                            retrieve: true

                        } );

                        table.draw();
                   alert_hide(); 
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
                $('#error_leave_for_employee').html(html_error);
                //$('#raise_msg_div').removeClass('alert-success').addClass('alert-danger').show();
                
                // Render the errors with js ...
              }
            });
      
          });

   
@endsection

