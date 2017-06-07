          <aside class="main-sidebar">

                  <!-- sidebar: style can be found in sidebar.less -->
                  <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                      <div class="info ellipsis" style="margin-top: 8px; margin-right: 10px;">
                        <p title="{{Session::get('customer_name')}}">{{Session::get('customer_name')}}</p>
                      </div>
                    </div>

                    <ul class="sidebar-menu">
                      @if(Route::current()->getName() == 'admin.crm.show')
                      <li class="active treeview">
                      @else
                      <li class="treeview">
                      @endif
                        <a href="{{ URL::route('admin.crm.show', session('cust_id'))}}">
                          <i class="fa fa-dashboard"></i> <span>Customer Dashboard</span> <i class="fa pull-right"></i>
                        </a>

                      </li>

                      @if(Route::current()->getName() == 'admin.ticket.index' && (Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin')))
                      <li class="active treeview bb">
                      @else
                      <li class="treeview">
                      @endif
                        <a href="{{ URL::route('admin.ticket.index')}}"><i class="fa  fa-tags"></i><span>Tickets</span></a>
                      </li>



                      @if(Route::current()->getName() == 'admin.assets.index' ||
                      Route::current()->getName() == 'admin.assets.nexpbx' || Route::current()->getName()=='admin.nexpbx.domain.devices' || Route::current()->getName()=='admin.nexpbx.assign.devices') 
                      <?php $display = '' ?>
                      <li class="active treeview">
                      @else
                      <?php $display = 'display: none;' ?>
                      <li class="treeview">
                      @endif
                        <a href="#">
                            <i class="fa fa-book"></i>
                            <span>Assets</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu" style="{{$display}}">
                          @if(Route::current()->getName() == 'admin.assets.index')
                          <li class="active treeview">
                          @else
                          <li>
                          @endif
                            <a href="{{ URL::route('admin.assets.index')}}"><i class="fa fa-angle-double-right"></i> <span>Devices</span></a>
                          </li>
                          @if(Route::current()->getName() == 'admin.assets.nexpbx' || Route::current()->getName() == 'admin.nexpbx.domain.devices' || Route::current()->getName()=='admin.nexpbx.assign.devices')
                          <li class="active treeview">
                          @else
                          <li>
                          @endif
                            <a href="{{ URL::route('admin.assets.nexpbx')}}"><i class="fa fa-angle-double-right"></i> <span>Nexpbx</span></a>
                          </li>
                        
                        </ul>
                      </li>




                      @if(Route::current()->getName() == 'admin.knowledge.networks')
                      <li class="active treeview">
                      @else
                      <li class="treeview">
                      @endif
                           <a href="{{ URL::route('admin.knowledge.networks')}}"><i class="fa  fa-sitemap "></i> <span>Networks</span></a>
                      </li>


                      <li class="treeview">
                     
                           <a href="{{ URL::route('admin.crm.notes.index')}}"><i class="fa  fa-sticky-note"></i> <span>Notes</span></a>


                      </li>

                      


                      @if(Route::current()->getName() == 'admin.knowledge.passwords.list' ||
                      Route::current()->getName() == 'admin.knowledge.procedures.list' ||
                      Route::current()->getName() == 'admin.knowledge.serial_numbers.list'  ||
                      Request::is('admin/crm/filemanager'))
                      <?php $display = '' ?>
                      <li class="active treeview">
                      @else
                      <?php $display = 'display: none;' ?>
                      <li class="treeview">
                      @endif
                        <a href="#">
                            <i class="fa fa-book"></i>
                            <span>Knowledge</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu" style="{{$display}}">
                          @if(Route::current()->getName() == 'admin.knowledge.passwords.list')
                          <li class="active treeview">
                          @else
                          <li>
                          @endif
                            <a href="{{ URL::route('admin.knowledge.passwords.list')}}"><i class="fa fa-angle-double-right"></i> <span>Passwords</span></a>
                          </li>
                          @if(Route::current()->getName() == 'admin.knowledge.procedures.list')
                          <li class="active treeview">
                          @else
                          <li>
                          @endif
                            <a href="{{ URL::route('admin.knowledge.procedures.list')}}"><i class="fa fa-angle-double-right"></i> <span>Procedures</span></a>
                          </li>
                          @if(Route::current()->getName() == 'admin.knowledge.serial_numbers.list')
                          <li class="active treeview">
                          @else
                          <li>
                          @endif
                            <a href="{{ URL::route('admin.knowledge.serial_numbers.list')}}"><i class="fa fa-angle-double-right"></i> <span>Serial Numbers</span></a>
                          </li>

                          
                          @if(Request::is('admin/crm/filemanager'))
                          <li class="active treeview">
                          @else
                          <li>
                          @endif
                                                
                            <a href="{{  url('admin/crm/filemanager')}}"><i class="fa fa-angle-double-right"></i> <span>Files</span></a>
                          </li>
                        </ul>
                      </li>

                      @if(Route::current()->getName() == 'admin.vendors.index')
                      <li class="active treeview">
                      @else
                      <li>
                      @endif
                        <a href="{{ URL::route('admin.vendors.index')}}"><i class="fa fa-group"></i> <span>Vendors</span></a>
                      </li>

                    </ul>

                    <div class="user-panel">
                      <div class="info ellipsis" style="margin-top: 8px; margin-right: 10px; ">
                        <p>General</p>
                      </div>
                    </div>

                    <ul class="sidebar-menu">
                    @include('admin.nav.general')


                  </section>
                  <!-- /.sidebar -->
                </aside>
