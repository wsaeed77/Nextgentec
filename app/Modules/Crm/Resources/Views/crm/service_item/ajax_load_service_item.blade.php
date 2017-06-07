         <input type="hidden" name="service_item_cust_id" id="service_item_cust_id" value="">
          <input type="hidden" name="service_item_id" value="" id="service_item_id">
         <div class="col-lg-12">
                       
              <div class="form-group col-lg-5">
                  <label>Service Type</label>
                   <?php //$service_types = [''=>'Pick a service type'];?>
                  {!! Form::select('service_type_id', $service_types,'',['class'=>'form-control multiselect required','placeholder' => 'Pick a service type','onChange'=>'dynamic_data(this.value);','id'=>'drp_dwn_srvc_type'])!!}
                  
              </div>
              <div class="col-lg-2">
                 
                      <img id="load_img" src="{{asset('img/loader.gif')}}" style="display:none" />
                  
              </div>
          </div>
              
          <div id="dynamic_data">
            <div class="col-lg-4" id="service_info">
    <div class="page-header">
        <h3>Service Info</h3>
    </div>
    <div class="form-group col-lg-12">
        <label>Service Item Name</label>
        {!! Form::input('text','service_item_name',$service_item->title, ['placeholder'=>"Service item name",'class'=>"form-control required"]) !!}
    </div>
    <div class="form-group col-lg-6">
        <label>Start date</label>
        {!! Form::input('text','start_date',date("m/d/Y", strtotime($service_item->start_date)), ['placeholder'=>"Start date",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
    </div>
    <div class="form-group col-lg-6">
        <label>End Date</label>
        {!! Form::input('text','end_date',date("m/d/Y", strtotime($service_item->end_date)), ['placeholder'=>"End",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
    </div>
    <div class="form-group col-lg-12">
    <?php /*if($service_item->is_active)
         $active = true;
         else
          $active = false;*/
        ?>
        <label class="radio-inline">{!! Form::checkbox('service_active', 1, $service_item->is_active); !!}</label>
        <label>Active</label>
        
        &nbsp;&nbsp;&nbsp;

        <?php /*if($service_item->is_default)
         $default = true;
         else
          $default = false;*/
        ?>
        <label class="radio-inline">{!! Form::checkbox('service_default', 1,$service_item->is_default); !!}</label>
        <label>Default service</label>
    </div>
</div>

<div class="col-lg-4" id="billing_info">
    <div class="page-header">
        <h3>Billing Info</h3>
    </div>
    <!--***************** for flate -fee and hourly*************-->
    @if(strtolower($service_item->service_type->title)==$hourly || strtolower($service_item->service_type->title)==$flate_fee)
    <div class="form-group col-lg-12">
        <label>Billing period</label>
        
        {!! Form::select('billing_period_id', $billing_arr,$service_item->billing_period->id,['class'=>'form-control multiselect','id'=>'subview'])!!}
    </div>
    <!--******************* for flate -fee*************-->
    @if(strtolower($service_item->service_type->title)==$flate_fee)
    <div class="form-group col-lg-6">
        <label>Unit price</label>
        <div class="form-group input-group col-lg-12">
            {{--  <label>Unit price</label> --}}
            <span class="input-group-addon">$</span>
            {!! Form::input('text','unit_price',$service_item->unit_price, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
            
        </div>
    </div>
    
    
    <div class="form-group col-lg-6">
        <label>Quantity</label>
        {!! Form::input('text','quantity',$service_item->quantity, ['placeholder'=>"0",'class'=>"form-control"]) !!}
    </div>
    @endif
    @endif
    <!--******************* for project*************-->
    @if(strtolower($service_item->service_type->title)==$project)
    <div class="form-group col-lg-12">
        
            <label>Project Estimate</label>
            <div class="form-group input-group col-lg-12">
                {{--  <label>Unit price</label> --}}
                <span class="input-group-addon">$</span>
                {!! Form::input('text','project_estimate',$service_item->estimate, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
                
            </div>
    </div>
        
        
    <div class="form-group col-lg-12">
            <label>Estimated Hours</label>
            {!! Form::input('text','estimated_hours',$service_item->estimated_hours, ['placeholder'=>"0",'class'=>"form-control"]) !!}
        
    </div>

    <div class="form-group col-lg-12">
        <label class="col-lg-4">Bill for</label>

        <label class="radio-inline col-lg-3">{!! Form::radio('bill_for', 'actual_hours',$service_item->bill_for=='actual_hours'?true:false) !!} Actual Hours</label>
        <label class="radio-inline col-lg-3">{!! Form::radio('bill_for', 'project_estimate',$service_item->bill_for=='project_estimate'?true:false) !!}Project Estimate</label>
        
    </div>
    @endif
    <!--******************* end for project*************-->
</div>  
          </div>
          <div class="col-lg-4" id="rates" >

              <div class="page-header">
                  <h3>Rates</h3>
              </div>

                  <div class="alert alert-success" id="rate_alert" style="display:none">
                     
                  </div>

                <?php //$rates = [''=>'Pick a default rate'];?>
              <div class="form-group col-lg-12">
                  <label>Default Rate</label>
                  <select name="default_rate" class="form-control multiselect" id="default_rate">
                  @foreach($service_item->rates as $rate)
                 
                  <option value="{{$rate->title.'|'.$rate->amount}}" <?php echo $rate->is_default?'selected':''; ?> >{{$rate->title}} {{'('.$rate->amount.')'}}</option>
                 
                  @endforeach
                  </select>
                 
                  
              </div>
              <div class="form-group col-lg-12">
                  <label>Additional Rates</label>
                    <?php //$additional_rates = [];?>

                  <select name="additional_rates[]" class="form-control multiselect" multiple id="additional_rate">
                  @foreach($service_item->rates as $rate)
                  
                  <option value="{{$rate->title.'|'.$rate->amount}}" <?php echo $rate->is_default==0? 'selected':''; ?>>{{$rate->title}} {{'('.$rate->amount.')'}}</option>
                  
                  @endforeach
                  </select>

                 

                  
              </div>
              <div class="form-group col-lg-9">
           
                <a href="javascript:;" onclick="show_rate_form()" class="btn btn-lg btn-success btn-block"><i class="fa fa-plus"></i> Add New Rate</a>
                  
              </div> 

               <div id="rate_form" class="col-lg-12" style="display:none">
               <div class="form-group col-lg-12">
                  <label>Title</label>
                  {!! Form::input('text','temp_rate_title', null,['class'=>'form-control','placeholder'=>"Rate title"])!!}
                  
              </div>
              <div class="form-group col-lg-12">
                  <label>Rate</label>
                  {!! Form::input('text','temp_amount',null, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
              </div>
              <div class="form-group col-lg-6">
           
                <a href="javascript:;" onclick="save_temporary_rate()" class="btn btn-lg btn-success btn-block">Save</a>
                  
              </div> 
              <div class="col-lg-2">
                 
                      <img id="load_img_rate" src="{{asset('img/loader.gif')}}" style="display:none" />
                  
              </div>
               </div>
          </div>
         
        <div style="clear:both"></div>
