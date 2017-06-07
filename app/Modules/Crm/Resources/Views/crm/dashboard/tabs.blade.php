<!-- Custom Tabs -->
<div class="nav-tabs-custom">
  <ul class="nav nav-tabs oh" style="height: 44px;">
    <li class="active"><a href="#contacts_tab" data-toggle="tab">Contacts</a></li>
    <li><a href="#locations_tab" data-toggle="tab">Locations</a></li>
    <li><a href="#networks_tab" data-toggle="tab">Networks</a></li>
    <li><a href="#contracts_tab" data-toggle="tab">Contracts</a></li>
    @ability('','zoho_view_invoices')
    <li><a href="#invoices_tab" data-toggle="tab">Invoices</a></li>
    @endability
    <li><a href="#tickets_tab" data-toggle="tab">Tickets</a></li>
    <li><a href="#notes_tab" data-toggle="tab">Notes</a></li>


  </ul>
  <div class="tab-content" style="padding: 15px 0 0 0;">
    <div class="tab-pane active" id="contacts_tab">
      <div class="col-md-12">
        <div class="f14 b titleBeforeBreak">
              Contacts
              <span class="pull-right">
                  <a href="#" data-id="{{$customer->id}}" data-target="#modal-add-new-contact" data-toggle="modal">
                      <span class="glyphicon glyphicon-plus p span-black" ng-click="addContact()">
                      </span>
                  </a>
              </span>
        </div>

        <div class="breakgray"></div><br>
      </div>
      @include('crm::crm.dashboard.contacts_tab')
      <div class="clearfix"></div>
    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane" id="locations_tab">
      <div class="col-md-12">
        <div class="f14 b titleBeforeBreak">
              Locations
              <span class="pull-right">
                  <a href="#" data-id="{{$customer->id}}" data-target="#modal-add-new-location" data-toggle="modal">
                      <span class="glyphicon glyphicon-plus p span-black" ng-click="addContact()">
                      </span>
                  </a>
              </span>
        </div>
        <div class="breakgray"></div><br>
      </div>
      @include('crm::crm.dashboard.locations_tab', ['customer->locations' => $customer->locations])
      <div class="clearfix"></div>
    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane" id="networks_tab">
      <div class="col-md-12">
        <div class="f14 b titleBeforeBreak">
              Networks
              <span class="pull-right">
                  <a ng-href="#/contact/add" href="#/contact/add">
                      <span class="glyphicon glyphicon-plus p span-black" ng-click="addContact()">
                      </span>
                  </a>
              </span>
        </div>
        <div class="breakgray"></div>
      @include('crm::crm.dashboard.networks_tab', ['customer->locations' => $customer->locations])
      </div>
      <div class="clearfix"></div>
    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane" id="contracts_tab">
      <div class="col-md-12">
        <div class="f14 b titleBeforeBreak">
              Contracts
              <span class="pull-right">
                  <a ng-href="#/contact/add" href="#/contact/add">
                      <span class="glyphicon glyphicon-plus p span-black" ng-click="addContact()">
                      </span>
                  </a>
              </span>
        </div>
        <div class="breakgray"></div><br>
      @include('crm::crm.dashboard.contracts_tab', ['customer->locations' => $customer->locations])
      </div>
      <div class="clearfix"></div>
    </div>
    <!-- /.tab-pane -->
    @ability('','zoho_view_invoices')
    <div class="tab-pane" id="invoices_tab">
      <div class="col-md-12">

      @include('crm::crm.dashboard.invoices_tab', ['customer->locations' => $customer->locations])
      </div>
      <div class="clearfix"></div>
    </div>
    @endability
    <!-- /.tab-pane -->
    <div class="tab-pane" id="tickets_tab">
      <div class="col-md-12">
        <div class="f14 b titleBeforeBreak">
              Tickets
              <span class="pull-right">
                  <a ng-href="#/contact/add" href="#/contact/add">
                      <span class="glyphicon glyphicon-plus p span-black" ng-click="addContact()">
                      </span>
                  </a>
              </span>
        </div>
        <div class="breakgray"></div><br>
      @include('crm::crm.dashboard.tickets_tab', ['customer->locations' => $customer->locations])
      </div>
      <div class="clearfix"></div>
    </div>
    <!-- /.tab-pane -->
    <div class="tab-pane" id="notes_tab">
      <div class="col-md-12">
        <div class="f14 b titleBeforeBreak">
              Notes
              <span class="pull-right">
                  <a ng-href="#/contact/add" href="#/contact/add">
                      <span class="glyphicon glyphicon-plus p span-black" ng-click="addContact()">
                      </span>
                  </a>
              </span>
        </div>
        <div class="breakgray"></div>
        @include('crm::crm.dashboard.notes_tab', ['customer->notes' => $customer->notes])
      </div>
      <div class="clearfix"></div>
    </div>


    <!-- /.tab-pane -->
  </div>
  <!-- /.tab-content -->
</div>
