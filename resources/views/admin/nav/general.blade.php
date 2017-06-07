
  @if(Route::current()->getName() == 'admin.dashboard')
  <li class="active treeview">
  @else
  <li>
  @endif
    <a href="{{ URL::route('admin.dashboard')}}">
      <i class="fa fa-dashboard"></i> <span>User Dashboard</span> <i class="fa pull-right"></i>
    </a>
  </li>


  @if(Route::current()->getName() == 'admin.employee.index' ||
  Route::current()->getName() == 'employee.leave.index' ||
  Route::current()->getName() == 'admin.leave.rejected' ||
  Route::current()->getName() == 'admin.leave.calendar' ||
  Route::current()->getName() == 'employee.leave.create'||
  Route::current()->getName() == 'employee.leave.own.index')
  <?php $display = '' ?>
  <li class="active treeview">
  @else
  <?php $display = 'display: none;' ?>
  <li class="treeview">
  @endif
    <a href="#">
        <i class="fa fa-cube"></i>
        <span>Hrm</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu" style="{{$display}}">
    @if(Auth::user()->hasRole('admin'))
      @if(Route::current()->getName() == 'admin.employee.index')
      <li class="active treeview">
      @else
      <li>
      @endif
        <a href="{{ URL::route('admin.employee.index')}}"><i class="fa fa-angle-double-right"></i> <span>Employees</span></a>
      </li>

      @if(Route::current()->getName() == 'admin.leave.rejected')
      <li class="active treeview">
      @else
      <li>
      @endif
        <a href="{{ URL::route('admin.leave.rejected')}}"><i class="fa fa-angle-double-right"></i> <span>Rejected Leaves</span></a>
      </li>

      @if(Route::current()->getName() == 'admin.leave.calendar')
      <li class="active treeview">
      @else
      <li>
      @endif
        <a href="{{ URL::route('admin.leave.calendar')}}"><i class="fa fa-angle-double-right"></i> <span>Calendar</span></a>
      </li>
    @endif

    @if(Auth::user()->type == 'employee' || Auth::user()->hasRole('admin'))
     @ability('','list_leaves,list_own_leaves')
      @if(Route::current()->getName() == 'employee.leave.index')
      <li class="active treeview">
      @else
      <li>
      @endif
        
            <a href="{{ URL::route('employee.leave.index')}}"><i class="fa fa-angle-double-right"></i> <span>List Leaves</span></a>
        
      </li>
    @endability 
    @endif

    @if(Auth::user()->type == 'employee')
      @ability('','list_own_leaves')
        @if(Route::current()->getName() == 'employee.leave.own.index')
        <li class="active treeview">
        @else
        <li>
        @endif
          <a href="{{ URL::route('employee.leave.own.index',Auth::user()->id)}}"><i class="fa fa-angle-double-right"></i> <span>List own leaves</span></a>
        </li>
      @endability

      @if(Route::current()->getName() == 'employee.leave.create')
      <li class="active treeview">
      @else
      <li>
      @endif
        <a href="{{ URL::route('employee.leave.create')}}"><i class="fa fa-angle-double-right"></i> <span>Post Leave</span></a>
      </li>
    @endif
    </ul>
  </li>
 