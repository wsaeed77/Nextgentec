<aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <ul class="sidebar-menu">

            @if(Route::current()->getName() == 'admin.setting.staff.employees' ||
            Route::current()->getName() == 'admin.setting.permissions' ||
            Route::current()->getName() == 'admin.employee.edit' ||
            Route::current()->getName() == 'admin.employee.show')
            <?php $display = '' ?>
            <li class="active treeview">
            @else
            <?php $display = 'display: none;' ?>
            <li class="treeview">
            @endif
              <a href="#">
                  <i class="fa fa-cube"></i>
                  <span>Staff</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="{{$display}}">
              @if(Auth::user()->hasRole('admin'))
                @if(Route::current()->getName() == 'admin.setting.staff.employees' ||
                Route::current()->getName() == 'admin.employee.edit' ||
                Route::current()->getName() == 'admin.employee.show')
                <li class="active treeview">
                @else
                <li>
                @endif
                  <a href="{{ URL::route('admin.setting.staff.employees')}}"><i class="fa fa-angle-double-right"></i> <span>Employees</span></a>
                </li>
                @if(Route::current()->getName() == 'admin.setting.permissions')
                <li class="active treeview">
                @else
                <li>
                @endif
                  <a href="{{ URL::route('admin.setting.permissions')}}"><i class="fa fa-angle-double-right"></i> <span>Permissions</span></a>
                </li>
              @endif

              </ul>
            </li>


            @if(Route::current()->getName() == 'admin.setting.general.system')
            <?php $display = '' ?>
            <li class="active treeview">
            @else
            <?php $display = 'display: none;' ?>
            <li class="treeview">
            @endif
              <a href="#">
                  <i class="fa fa-cube"></i>
                  <span>General</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="{{$display}}">
              @if(Auth::user()->hasRole('admin'))
                @if(Route::current()->getName() == 'x')
                <li class="active treeview">
                @else
                <li>
                @endif
                  <a href="{{ URL::route('admin.employee.index')}}"><i class="fa fa-angle-double-right"></i> <span>Company</span></a>
                </li>
                @if(Route::current()->getName() == 'admin.setting.general.system')
                <li class="active treeview">
                @else
                <li>
                @endif
                  <a href="{{ URL::route('admin.setting.general.system')}}"><i class="fa fa-angle-double-right"></i> <span>System</span></a>
                </li>
              @endif

              </ul>
            </li>

            @if(Route::current()->getName() == 'admin.setting.ticketing.statuses')
            <?php $display = '' ?>
            <li class="active treeview">
            @else
            <?php $display = 'display: none;' ?>
            <li class="treeview">
            @endif
              <a href="#">
                  <i class="fa fa-cube"></i>
                  <span>Ticketing</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="{{$display}}">
              @if(Auth::user()->hasRole('admin'))
                @if(Route::current()->getName() == 'admin.setting.ticketing.statuses')
                <li class="active treeview">
                @else
                <li>
                @endif
                  <a href="{{ URL::route('admin.setting.ticketing.statuses')}}"><i class="fa fa-angle-double-right"></i> <span>Statuses</span></a>
                </li>
              @endif

              </ul>
            </li>

            @if(Route::current()->getName() == 'admin.setting.crm.defaultrates' ||
            Route::current()->getName() == 'admin.setting.crm.billingperiods'||
            Route::current()->getName() == 'admin.setting.crm.servicetypes')
            <?php $display = '' ?>
            <li class="active treeview">
            @else
            <?php $display = 'display: none;' ?>
            <li class="treeview">
            @endif
              <a href="#">
                  <i class="fa fa-cube"></i>
                  <span>CRM</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="{{$display}}">
              @if(Auth::user()->hasRole('admin'))
                @if(Route::current()->getName() == 'admin.setting.crm.defaultrates')
                <li class="active treeview">
                @else
                <li>
                @endif
                  <a href="{{ URL::route('admin.setting.crm.defaultrates')}}"><i class="fa fa-angle-double-right"></i> <span>Default Rates</span></a>
                </li>
                @if(Route::current()->getName() == 'admin.setting.crm.billingperiods')
                <li class="active treeview">
                @else
                <li>
                @endif
                  <a href="{{ URL::route('admin.setting.crm.billingperiods')}}"><i class="fa fa-angle-double-right"></i> <span>Billing Periods</span></a>
                </li>
                @if(Route::current()->getName() == 'admin.setting.crm.servicetypes')
                <li class="active treeview">
                @else
                <li>
                @endif
                  <a href="{{ URL::route('admin.setting.crm.servicetypes')}}"><i class="fa fa-angle-double-right"></i> <span>Service Types</span></a>
                </li>
              @endif
              </ul>
            </li>


            @if(Auth::user()->hasRole('admin'))
            @if(Route::current()->getName() == 'admin.setting.crm.integration.zoho' || Route::current()->getName() == 'admin.setting.crm.integration.slack' || Route::current()->getName() == 'admin.setting.crm.integration.gmail')
            <?php $display = '' ?>
            <li class="active treeview">
            @else
            <?php $display = 'display: none;' ?>
            <li class="treeview">
            @endif
              <a href="#">
                  <i class="fa fa-cube"></i>
                  <span>Integrations</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="{{$display}}">
             
                @if(Route::current()->getName() == 'admin.setting.crm.integration.zoho')
                  <li class="active treeview">
                @else
                  <li>
                @endif
                  <a href="{{ URL::route('admin.setting.crm.integration.zoho')}}"><i class="fa fa-angle-double-right"></i> <span>Zoho Invoices</span></a>
                </li>


                @if(Route::current()->getName() == 'admin.setting.crm.integration.slack')
                  <li class="active treeview">
                @else
                  <li>
                @endif
                  <a href="{{ URL::route('admin.setting.crm.integration.slack')}}"><i class="fa fa-angle-double-right"></i> <span>Slack</span></a>
                </li>

                  @if(Route::current()->getName() == 'admin.setting.crm.integration.gmail')
                  <li class="active treeview">
                @else
                  <li>
                @endif
                  <a href="{{ URL::route('admin.setting.crm.integration.gmail')}}"><i class="fa fa-angle-double-right"></i> <span>Gmail Integration</span></a>
                </li>
               
              
              </ul>
            </li>
            @endif



             @if(Auth::user()->hasRole('admin'))
            @if(Route::current()->getName() == 'admin.setting.crm.assets.asset_server_roles' || Route::current()->getName() == 'admin.setting.crm.assets.asset_server_virtual_types'  )
            <?php $display = '' ?>
            <li class="active treeview">
            @else
            <?php $display = 'display: none;' ?>
            <li class="treeview">
            @endif
              <a href="#">
                  <i class="fa fa-cube"></i>
                  <span>Assets</span>
                  <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="{{$display}}">
             
                @if(Route::current()->getName() == 'admin.setting.crm.assets.asset_server_roles')
                  <li class="active treeview">
                @else
                  <li>
                @endif
                  <a href="{{ URL::route('admin.setting.crm.assets.asset_server_roles')}}"><i class="fa fa-angle-double-right"></i> <span>Asset server roles</span></a>
                </li>


                @if(Route::current()->getName() == 'admin.setting.crm.assets.asset_server_virtual_types')
                  <li class="active treeview">
                @else
                  <li>
                @endif
                  <a href="{{ URL::route('admin.setting.crm.assets.asset_server_virtual_types')}}"><i class="fa fa-angle-double-right"></i> <span>Asset server virtual types</span></a>
                </li>
              
              </ul>
            </li>
            @endif



          </ul>

        </section>
        <!-- /.sidebar -->
      </aside>
