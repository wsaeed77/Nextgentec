<?php
namespace App\Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Http\Employee;
use App\Modules\Employee\Http\Requests\EmployeePostRequest;
use App\Model\Role;
use App\Model\User;
use Auth;

use App\Modules\Employee\Http\Leave;

use App\Services\GoogleCalendar;
use App\Services\TimeZone;

class EmployeeController extends Controller
{
    private $controller = 'employee';


    public function index()
    {
      
        $controller = $this->controller;
        $employees = User::where('type', 'employee')->get();
        $route_delete = 'admin.employee.destroy';

        return view('employee::admin.index', compact('employees', 'controller', 'route_delete'));
    }
    public function getById($id)
    {

        $user = User::find($id);


        return view('admin.setting.user_ajax_get', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles_obj = Role::select(['id','display_name'])->get();
        $manager_obj =  Role::with('users')->where('name', 'manager')->first();
        $managers = [];
        $roles = [];
        
        if ($manager_obj->users->count()) {
            foreach ($manager_obj->users as $user) {
                $managers[$user->id]=$user->f_name." ".$user->l_name;
                //dd($user->id);
            }
        }
        if ($roles_obj->count()) {
            foreach ($roles_obj as $role) {
                $roles[$role->id]=$role->display_name;
                //dd($user->id);
            }
        }

           $timezone = new TimeZone();
        $time_zones = $timezone->timezone_list();

        return view('employee::admin.add', compact('roles', 'managers', 'time_zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeePostRequest $request)
    {
        //dd(date( "Y-m-d",strtotime($request->hire_date)));
        //dd($request->all());

        $user = new User;
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;

        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->phone) {
            $user->phone = $request->phone;
        }
        if ($request->mobile) {
            $user->mobile = $request->mobile;
        }
        $user->type = $request->type;
        $user->save();

        $employee             = new Employee;
        $employee->pay_type   = $request->pay_type;
        $employee->hire_date  = date("Y-m-d", strtotime($request->hire_date));
        $employee->birth_date = date("Y-m-d", strtotime($request->birth_date));

        if ($request->fax) {
            $employee->fax                     = $request->fax;
        }
        $employee->managed_by              = $request->managed_by;
        $employee->billable_rate           = $request->billable_rate;
        $employee->cost_rate               = $request->cost_rate;
        $employee->pay_rate                = $request->pay_rate;
        $employee->vacation_yearly         = $request->vacation_yearly;
        $employee->sick_days_yearly        = $request->sick_days_yearly;
        $employee->withholding_tax_rate    = $request->withholding_tax_rate;
        $employee->home_address            = $request->home_address;
        $employee->time_zone               = $request->time_zone;
        $employee->emergency_contact_name  = $request->emergency_contact_name;
        $employee->emergency_contact_phone = $request->emergency_contact_phone;
        $employee->health_insurance        = $request->health_insurance;
        $employee->life_insurance          = $request->life_insurance;
        $employee->retirement              = $request->retirement;
        $user->employee()->save($employee);
        if ($request->role) {
            $user->attachRole($request->role);
        }

        return redirect()->intended('admin/employee');
    }

    public function ajaxStore(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required',
                 'f_name' => 'required',
                  'l_name' => 'required',

            ]
        );
        if ($request->password !=='') {
             $this->validate(
                 $request,
                 [
                 'password' => 'required|confirmed|min:6',

                 ]
             );
        }

        //$user = User::find($request->user_id);
        $user = User::find(Auth::user()->id);
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->mobile = $request->mobile;
            $user->exten = $request->exten;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        $arr['success'] = 'Profile updated successfully';
        return json_encode($arr);
        exit;
        //return redirect()->intended('admin/employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $employee         = User::where('id', $id)->with('employee', 'roles', 'leave')->first();
        //$availed_leaves = Leave::where('user_id',$id)->where('status','approved')->get()->count();



          $availed_leaves = Leave::where('posted_for', $id)
                                      ->where('status', 'approved')
                                      ->selectRaw('category,sum(duration) as sum,type')
                                      ->groupBy(['category','type'])->get();
          $annual = [];
          $sick = [];
        foreach ($availed_leaves as $value) {
            //dd($value);
            if ($value->type=='sick') {
                if ($value->category=='short') {
                    $sick['short'] = $value->sum/8;
                }

                if ($value->category=='full') {
                    $sick['full'] = $value->sum;
                }
            }

            if ($value->type=='annual') {
                if ($value->category=='short') {
                    $annual['short'] = $value->sum/8;
                }

                if ($value->category=='full') {
                    $annual['full'] = $value->sum;
                }
            }
        }

          //dd($sick);

        $availed_annual_leaves = number_format((isset($annual['full'])?$annual['full']:0), 2)+ number_format((isset($annual['short'])?$annual['short']:0), 2);

        $availed_sick_leaves = number_format((isset($sick['full'])?$sick['full']:0), 2)+ number_format((isset($sick['short'])?$sick['short']:0), 2);

        return view('employee::employee_dashboard.show', compact('employee', 'sick_leaves', 'availed_annual_leaves', 'availed_sick_leaves', 'annual_leaves'));

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee    = User::where('id', $id)->with('employee')->first();
        $roles_obj   = Role::select(['id','display_name'])->get();
        $manager_obj =  Role::with('users')->where('name', 'manager')->first();
        //dd($employee->raise);
        $managers = [];

        $user_role = [];
        $managers = [];
        $roles = [];

        if ($manager_obj->users->count()) {
            foreach ($manager_obj->users as $user) {
                $managers[$user->id]=$user->f_name." ".$user->l_name;
                //dd($user->id);
            }
        }
        if ($roles_obj->count()) {
            foreach ($roles_obj as $role) {
                $roles[$role->id]=$role->display_name;
                //dd($user->id);
            }
        }
        if ($employee->roles) {
            foreach ($employee->roles as $role) {
                $user_role = $role->id;
            //dd($role->display_name);
            }
        }
        $timezone = new TimeZone();
     
        $time_zones = $timezone->timezone_list();
        return view('employee::admin.edit', compact('employee', 'roles', 'user_role', 'managers', 'time_zones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeePostRequest $request, $id)
    {

            $user   = User::find($id);
            $user->f_name                      = $request->f_name;
            $user->l_name                      = $request->l_name;

            $user->email                       = $request->email;
        if ($request->password) {
            $user->password                    = bcrypt($request->password);
        }

        if ($request->phone) {
            $user->phone                       = $request->phone;
        }
        if ($request->mobile) {
            $user->mobile                      = $request->mobile;
        }
            $user->type                        = $request->type;
            $user->save();

            //$employee                        = Employee::where('user_id',$id)->first();
            $employee                          = $user->employee;
            $employee->pay_type                = $request->pay_type;
            $employee->hire_date               = date("Y-m-d", strtotime($request->hire_date));
            $employee->birth_date              = date("Y-m-d", strtotime($request->birth_date));

        if ($request->fax) {
            $employee->fax                     = $request->fax;
        }
            $employee->managed_by              = $request->managed_by;
            $employee->billable_rate           = $request->billable_rate;
            $employee->cost_rate               = $request->cost_rate;
            $employee->pay_rate                = $request->pay_rate;
            $employee->vacation_yearly         = $request->vacation_yearly;
            $employee->sick_days_yearly        = $request->sick_days_yearly;
            $employee->withholding_tax_rate    = $request->withholding_tax_rate;
            $employee->time_zone               = $request->time_zone;
            $employee->home_address            = $request->home_address;
            $employee->health_insurance        = $request->health_insurance;
            $employee->life_insurance          = $request->life_insurance;
            $employee->retirement              = $request->retirement;

            $employee->emergency_contact_name  = $request->emergency_contact_name;
            $employee->emergency_contact_phone = $request->emergency_contact_phone;

            $user->employee()->save($employee);
            $user->detachRoles($user->roles);
            $user->attachRole($request->role);

        return redirect()->intended('admin/employee');
        //return redirect()->intended('admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy(Request $request)
    {
        //dd($id);
        //dd($request->id);
        $id = $request->id;
        $user = User::findorFail($id);
        $user->detachRoles($user->roles);
        $user->employee()->delete();
        $user->delete();
       
        return redirect()->intended('admin/employee');
    }






    public function googleCalander()
    {

        $calendar   = new GoogleCalendar;
        $calendarId = "adnan.nexgentec@gmail.com";
        $result     = $calendar->get($calendarId);

        $calendar->eventPost([
                  'summary' => 'Google I/O 2015',
                  'location' => '800 Howard St., San Francisco, CA 94103',
                  'description' => 'A chance to hear more about Google\'s developer products.',
                  'start' => [
                    'dateTime' => '2015-05-28T09:00:00-07:00',
                    'timeZone' => 'America/Los_Angeles',
                  ],
                  'end' => [
                    'dateTime' => '2015-05-28T17:00:00-07:00',
                    'timeZone' => 'America/Los_Angeles',
                  ],
                  'recurrence' => [
                    'RRULE:FREQ=DAILY;COUNT=2'
                  ],
                  'attendees' => [
                    ['email' => 'lpage@example.com'],
                    ['email' => 'sbrin@example.com'],
                  ],
                  'reminders' => [
                    'useDefault' => false,
                    'overrides' => [
                      ['method' => 'email', 'minutes' => 24 * 60],
                      ['method' => 'popup', 'minutes' => 10],
                    ],
                  ],
                ], $calendarId);


     
            exit;
      //return view('employee::admin.edit',compact('result'));
    }
}
