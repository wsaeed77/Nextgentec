  <header class="main-header">
        <!-- Logo -->
        <a href="/admin/dashboard" class="logo hidden-xs">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>N</b>xt</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Nex</b>gentec</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
        <!-- Header Navbar: style can be found in header.less -->

            <a href="#" class="sidebar-toggle" id="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        {{-- <div class="clearfix"></div> --}}
       {{--  <div class="navbar-left hidden-lg hidden-md hidden-sm">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <a href="" ng-click="toggleSearch()">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
            </ul>
        </div> --}}

        @if(session('panel')!='admin')
        <div class="navbar-left hidden-xs">
           <form class="navbar-form no-padding ng-pristine ng-valid" role="search">
               <div class="typeahead__container input-group input-group-search">
                 <div class="typeahead__field">
                 <span class="typeahead__query">
                  <input class="js-typeahead-input" id="js-typeahead-input" name="q" type="search" autofocus  autocomplete="off">
                 </span>
                 <span class="typeahead__button">
                     <!-- <button type="submit">
                         <span class="typeahead__search-icon"></span>
                     </button> -->
                 </span>
                 </div>
               </div>
           </form>
         </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">

          @if(Auth::user()->hasRole('technician'))
          <li><a href=" {{ URL::route('admin.ticket.list_own')}}">Helpdesk</a></li>
          @endif

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">CRM <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
            <li><a href="{{ URL::route('admin.crm.index')}}">Customers</a></li>
            </ul>
          </li>

          <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hrm <span class="caret"></span></a>
            @role('admin')
              <ul class="dropdown-menu" role="menu">
               <li><a href="{{ URL::route('admin.employee.index')}}"> Employees</span></a></li>
              <li><a href="{{ URL::route('employee.leave.index')}}"> List Leaves</a></li>

               {{--  <li><a href="{{ URL::route('admin.leave.rejected')}}"> Rejected Leaves</a></li> --}}
                <li><a href="{{ URL::route('admin.leave.calendar')}}"> Calendar</a></li>
              </ul>
            @endrole
            @if(Auth::user()->type == 'employee')
               <ul class="dropdown-menu" role="menu">
              @ability('','list_own_leaves')
                <li><a href="{{ URL::route('employee.leave.own.index',Auth::user()->id)}}"> List own leaves</a></li>
              @endability
              @ability('','list_leaves')
                <li><a href="{{ URL::route('employee.leave.index')}}"> List Leaves</a></li>
                @endability
                <li><a href="{{ URL::route('employee.leave.create')}}"> Post Leave</a></li>
              </ul>
            @endif
          </li>

          </ul>
        </div>
        <!-- /.navbar-collapse -->
  			@endif

          <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu navbar-righ">
          <ul class="nav navbar-nav">
            @if(session('panel')=='admin')
            <li><a href="{{ URL::route('admin.setting.exit')}}">Agent Panel</a></li>
            @else
            <li><a href="{{ URL::route('admin.setting.all')}}">Admin Panel</a></li>
            @endif
            @if(session('panel')!='admin')
            <li class="dropdown user user-menu">
                <a class="dropdown-toggle p" data-toggle="dropdown" role="button" aria-expanded="true">
                    <span class="glyphicon glyphicon-plus"></span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#/ticket/add">New Ticket</a></li>
                    <li><a href="#/contact/add">New Contact</a></li>
                    <li><a href="#/customer/wizard">New Customer</a></li>
                    <li data-ng-class="::{ 'disabled': !isProfessional }"><a data-ng-href="#/rmm/add/device/snmp" href="#/rmm/add/device/snmp">New SNMP</a></li>
                    <li data-ng-class="::{ 'disabled': !isProfessional }"><a data-ng-href="#/rmm/add/device/tcp" href="#/rmm/add/device/tcp">New TCP</a></li>
                    <li data-ng-class="::{ 'disabled': !isProfessional }"><a data-ng-href="#/rmm/add/device/http" href="#/rmm/add/device/http">New HTTP</a></li>
                    <li data-ng-class="::{ 'disabled': !isProfessional }"><a data-ng-href="#/rmm/add/device/generic" href="#/rmm/add/device/generic">New Generic</a></li>
                    <li class="divider"></li>
                    <li data-ng-class="::{ 'disabled': !isProfessional }"><a href="" class="p" ng-click="downloadAgentInstllation()">Download Agent</a></li>
                </ul>
            </li>

            <li class="dropdown user user-menu alert-menu">
                <a class="dropdown-toggle p" data-toggle="dropdown" role="button" aria-expanded="true" title="Undefined Agents / Alerts" ng-click="navItemsClick()">
                    <span class="fa fa fa-bell" id="navBellIcon" style="margin-right: 0px;"></span>
                    <span class="label" ng-class="{ 'label-info' : navRefresh_severity == 1 , 'label-warning' : navRefresh_severity == 2 , 'label-danger' : navRefresh_severity == 3}" ng-visible="navRefresh_count > 0" style="visibility: hidden;">0</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">

                    <!-- ngIf: navAlertsFetching || navAgentsFetching -->

                    <!-- ngIf: !navAlertsFetching && !navAgentsFetching && !navList.length --><li class="header" ng-if="!navAlertsFetching &amp;&amp; !navAgentsFetching &amp;&amp; !navList.length" style="padding: 10px;">No new items
                    </li><!-- end ngIf: !navAlertsFetching && !navAgentsFetching && !navList.length -->

                    <!-- ngRepeat: not in navList track by not.TrackID -->
                </ul>
            </li>
            @endif

              <li class="dropdown user user-menu">
                <a class="dropdown-toggle p" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span>{{Auth::user()->f_name}}</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a  id="modaal" data-toggle="modal" data-target="#modal-user-settings" {{-- href="{{ URL::route('admin.setting.all')}}" --}}>Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ URL::route('admin.logout')}}" ng-click="/admin/logout" class="p">Logout</a></li>
                </ul>
              </li>
          </ul>
        </div>



        </nav>

        <style>
        @media (max-width: 768px) {
            .navbar-collapse.pull-left + .navbar-custom-menu{
              position: unset;
            }
          }
        </style>
      </header>
