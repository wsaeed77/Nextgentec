<div class="container" >
    <form  method="POST" id="raises">
        <div class="form-group col-lg-2">
            <label>Effective Date</label>
            {!! Form::input('text','effective_date',null, ['placeholder'=>"Effective Date",'class'=>"form-control datepicker",'data-date-format'=>"mm/dd/yyyy"]) !!}
            <input type="hidden" name="user_id" value="{{ $employee->employee->user_id}}">
        </div>
        <div class="form-group col-lg-2">
            <label>Old Pay</label>
            {!! Form::input('text','old_pay',null, ['placeholder'=>"Old Pay",'class'=>"form-control"]) !!}
            
        </div>
        <div class="form-group col-lg-2">
            <label>New Pay</label>
            {!! Form::input('text','new_pay',null, ['placeholder'=>"New Pay",'class'=>"form-control"]) !!}
            
        </div>
        <div class="form-group col-lg-4">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
            
        </div>
        <div class="form-group col-lg-2">
            <div>&nbsp;</div>
            <br/>
            <a href="#" id="raise_submit" class="btn btn-lg btn-success btn-block">Add</a>
            
        </div>
    </form>
</div>