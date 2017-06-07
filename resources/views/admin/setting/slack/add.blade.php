 <div class="box-body table-responsive">

 <a href="javascript:;" onclick="slack_authorize();" class="btn btn-sm btn-primary pull-right">Reset Auth Token</a>

   </div>
<div class="box-body table-responsive">
       
 <div class="col-lg-12">
<form id="update_slack_form">      
    <div class="form-group col-lg-4">
        <label>Client ID</label>
        {!! Form::input('text','client_id',$slack_arr['client_id'], ['placeholder'=>"Client ID",'class'=>"form-control"]) !!}
        
    </div>

     <div class="form-group col-lg-4">
        <label>Client Secret</label>
        {!! Form::input('text','secret',$slack_arr['secret'], ['placeholder'=>"Client Secret",'class'=>"form-control"]) !!}
    </div>
<div class="form-group col-lg-4">
        <label>Channel</label>
        {!! Form::input('text','channel',$slack_arr['channel'], ['placeholder'=>"Channel",'class'=>"form-control"]) !!}
    </div>
     <div class="form-group col-lg-6">
        <label>Redirect URI</label>
        {!! Form::input('text','redirect_uri',$slack_arr['redirect_uri'], ['placeholder'=>"Redirect URI",'class'=>"form-control"]) !!}
    </div>
   <div class="form-group col-lg-6">
        <label>Access Token</label>
        {!! Form::input('text','access_token',$slack_arr['access_token'], ['placeholder'=>"Access Token",'class'=>"form-control"]) !!}
    </div>
    
</form>
</div>

 <div class="col-lg-12">
        <div class="form-group col-lg-2 pull-right">
            <button type="submit" class="btn btn-md btn-success btn-block update_slack">Update</button>
        </div>
</div>
   
<div class="clearfix"></div>
</div>
