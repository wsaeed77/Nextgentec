<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            {{-- <div class="pull-left image">
              <img src="{{ URL::asset('img/avatar.png')}}" class="img-circle" alt="User Image">
            </div> --}}
            <div class="pull-left info">
              <p>{{Auth::user()->f_name.' '.Auth::user()->l_name}} </p>
              {{-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> --}}
            </div>
          </div>
          <ul class="sidebar-menu">
            @include('admin.nav.general')

            @if(Route::current()->getName() == 'admin.crm.index')
            <li class="active treeview">
            @else
            <li>
            @endif
              <a href="{{ URL::route('admin.crm.index')}}"><i class="fa fa-cubes"></i>CRM</a>
            </i>
            @if(Route::current()->getName() == 'admin.ticket.index' && (Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin')))
                      <li class="active treeview bb">
                      @else
                      <li class="treeview">
                      @endif
                        <a href="{{ URL::route('admin.ticket.index')}}"><i class="fa  fa-tags"></i><span>Tickets</span></a>
                      </li>

              @if(Route::current()->getName() == 'admin.vendors.index' & (Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin')))
                      <li class="active treeview">
                      @else
                      <li>
                      @endif
                        <a href="{{ URL::route('admin.vendors.index')}}"><i class="fa fa-group"></i> <span>Vendors</span></a>
                      </li>

             @if(Route::current()->getName() == 'admin.nexpbx.index')
            <li class="active treeview">
            @else
            <li>
            @endif
                <a href="{{ URL::route('admin.nexpbx.index')}}"><i class="fa fa-book"></i> <span>Nexpbx</span></a>
          </li>

            @if(Route::current()->getName() == 'admin.setting.all')
            <li class="active treeview">
            @else
            <li>
            @endif
                <a href="{{ URL::route('admin.setting.all')}}"><i class="fa fa-gears"></i> <span>Settings</span></a>
          </li>
           


        </section>
        <!-- /.sidebar -->
      </aside>
