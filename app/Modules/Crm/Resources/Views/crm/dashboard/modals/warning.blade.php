<div class="modal fade modal-warning" id="modal-warning">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          ×
        </button>
        <h4 class="modal-title">Warning</h4>
        <span>{{$customer->name}}</span>
      </div>
      <div class="modal-body">
        <h4>Credit Limit Exceeded</h4>
        <p>This client has exceeded their credit limit and will need to pay
        down their balance before any additional credit is given.</p>
        <div class="row">
          <div class="col-md-6">
            <span class="b">Test</span>
            <ul style="list-style-type:none;">
              @foreach($customer->locations as $location)
                <li>{{$location->location_name}}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
