<div class="col-lg-4" id="service_info">
    <div class="page-header">
        <h3>Service Info</h3>
    </div>
    <div class="form-group col-lg-12">
        <label>Service Item Name</label>
        {!! Form::input('text','service_item_name',$service_item->description, ['placeholder'=>"Service item name",'class'=>"form-control required"]) !!}
    </div>
    <div class="form-group col-lg-6">
        <label>Start date</label>
        {!! Form::input('text','start_date',date("m/d/Y", strtotime("first day of this month")), ['placeholder'=>"Start date",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
    </div>
    <div class="form-group col-lg-6">
        <label>End Date</label>
        {!! Form::input('text','end_date',date("m/d/Y", strtotime("last day of this month")), ['placeholder'=>"End",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
    </div>
    <div class="form-group col-lg-12">
        <label class="radio-inline">{!! Form::checkbox('service_active', 1, true); !!}</label>
        <label>Active</label>
        
        &nbsp;&nbsp;&nbsp;
        <label class="radio-inline">{!! Form::checkbox('service_default', 1); !!}</label>
        <label>Default service</label>
    </div>
</div>

<div class="col-lg-4" id="billing_info">
    <div class="page-header">
        <h3>Billing Info</h3>
    </div>
    <!--***************** for flate -fee and hourly*************-->
    @if(strtolower($service_item->title)==$hourly || strtolower($service_item->title)==$flate_fee)
    <div class="form-group col-lg-12">
        <label>Billing period</label>
        
        {!! Form::select('billing_period_id', $billing_arr,'',['class'=>'form-control multiselect_crm','id'=>'subview'])!!}
    </div>
    <!--******************* for flate -fee*************-->
    @if(strtolower($service_item->title)==$flate_fee)
    <div class="form-group col-lg-6">
        <label>Unit price</label>
        <div class="form-group input-group col-lg-12">
            {{--  <label>Unit price</label> --}}
            <span class="input-group-addon">$</span>
            {!! Form::input('text','unit_price',null, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
            
        </div>
    </div>
    
    
    <div class="form-group col-lg-6">
        <label>Quantity</label>
        {!! Form::input('text','quantity',null, ['placeholder'=>"0",'class'=>"form-control"]) !!}
    </div>
    @endif
    @endif
    <!--******************* for project*************-->
    @if(strtolower($service_item->title)==$project)
    <div class="form-group col-lg-12">
        
            <label>Project Estimate</label>
            <div class="form-group input-group col-lg-12">
                {{--  <label>Unit price</label> --}}
                <span class="input-group-addon">$</span>
                {!! Form::input('text','project_estimate',null, ['placeholder'=>"0.00",'class'=>"form-control"]) !!}
                
            </div>
    </div>
        
        
    <div class="form-group col-lg-12">
            <label>Estimated Hours</label>
            {!! Form::input('text','estimated_hours',null, ['placeholder'=>"0",'class'=>"form-control"]) !!}
        
    </div>

    <div class="form-group col-lg-12">
        <label>Bill for</label>
        <label class="radio-inline">{!! Form::radio('bill_for', 'actual_hours',true) !!} Actual Hours</label>
        <label class="radio-inline">{!! Form::radio('bill_for', 'project_estimate') !!}Project Estimate</label>
        
    </div>
    @endif
    <!--******************* end for project*************-->
</div>

