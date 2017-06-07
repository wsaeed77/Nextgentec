<?php
namespace App\Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Http\Employee;
use App\Modules\Employee\Http\Leave;
use App\Modules\Employee\Http\Requests\LeavePostRequest;

use App\Services\GoogleCalendar;
use App\Model\Role;
use App\Model\User;
use Auth;

use App\Model\Config;
use Datatables;
use Session;
class LeaveController extends Controller
{
	private $controller = 'leave';


	 public function index($id=Null)
    {
      //dd(Auth::user());

        $controller = $this->controller;
        $route_delete = 'employee.leave.destroy';
       // $leaves = Leave::where('user_id',Auth::user()->id)->with(['user'])->get();
   if($id)
        return view('employee::leave.list_own_leaves',compact('controller','route_delete'));

    else
        return view('employee::leave.list_all_leaves',compact('controller','route_delete'));
    }

    public function allListLeaves($id=Null)
    {
        //dd($request);
         $date_format = Config::where('title','date_format')->first();

        
       if($id)
            $leaves = Leave::where('posted_for',$id)->with(['poster','applicant','action_taker','poster.roles'])->select('leaves.*','users.f_name','users.l_name')
           ->join('users', 'leaves.posted_for', '=', 'users.id');
        else
            $leaves = Leave::with(['poster','applicant','action_taker','poster.roles'])->select('leaves.*','users.f_name','users.l_name')
           ->join('users', 'leaves.posted_for', '=', 'users.id')->where('leaves.posted_for','!=',Auth::user()->id);




           return Datatables::of($leaves)

            ->editColumn('start_date', function ($leave) use($date_format) {

                return  date($date_format->key,strtotime($leave->start_date));
            })

           /*  ->editColumn('type', function ($leave) {

                return  $leave->type;
            })*/

            ->editColumn('end_date', function ($leave) use($date_format) {

                return  date($date_format->key,strtotime($leave->end_date));
            })

             ->editColumn('category', function ($leave) {
                if($leave->category=='short')
                    return  '<span class="badge bg-blue">Short</span>';
                else
                    return '<span class="badge bg-blue">Full Day</span>';
            })

            ->editColumn('created_at', function ($leave) use($date_format) {

                return  date($date_format->key,strtotime($leave->created_at));
            })

            ->editColumn('posted_by', function ($leave)  {
                if($leave->posted_by== $leave->posted_for)
                    return  '<button type="button" class="btn bg-gray-active  btn-sm">
                            <i class="fa fa-user"></i>
                                <span>'.$leave->poster->f_name.' '.$leave->poster->l_name.'</span>
                            </button>';
                else
                    return  '<button type="button" class="btn bg-gray-active  btn-sm">
                            <i class="fa fa-user"></i>
                                <span>'.$leave->poster->f_name.' '.$leave->poster->l_name.' ('.$leave->poster->roles[0]->name.')</span>
                            </button>';

            })



            ->addColumn('days', function ($leave){
                if($leave->category=='full')
                    return  '<span class="badge bg-blue">'.$leave->duration.'</span>';
                else
                    return  '---';

            })

             ->addColumn('applicant', function ($leave){
               return '<button type="button" class="btn bg-gray-active  btn-sm">
                            <i class="fa fa-user"></i>
                                <span>'.$leave->applicant->f_name.' '.$leave->applicant->l_name.'</span>
                            </button>';

            })

            ->addColumn('hours', function ($leave){
                if($leave->category=='short')
                    return  '<span class="badge bg-blue">'.$leave->duration.'</span>';
                else
                    return  '---';

            })


           ->editColumn('status', function ($leave){
                 if($leave->status == 'pending')
                    return '<button class="btn btn-sm btn-warning" type="button">Pending</button>';
                if($leave->status == 'approved')
                    return '<button class="btn btn-sm btn-success" type="button">Approved</button>';
                if($leave->status == 'rejected')
                    return '<button class="btn btn-sm btn-danger" type="button">Rejected</button>';

            })
           ->addColumn('action', function ($leave) use($id){
                    $return = '';
                   /* <img id="load_img" src="{{asset('img/loader.gif')}}" style="display:none" />*/
                   if($leave->status=='pending' && !isset($id))
                   {
                        $return ='<button type="button" class="btn btn-success btn-sm"  data-id="'.$leave->id.'" id="approve'.$leave->id.'" onclick="approve('.$leave->id.')">
                        Approve
                        </button>';


                        $return .= ' <button type="button" class="btn btn-danger btn-sm" data-id="'.$leave->id.'" id="modaal-hide'.$leave->id.'"  data-toggle="modal" data-target="#modal-reject">
                    <i class="fa fa-times-circle"></i>
                    Reject
                    </button>';
                   }
                   if($leave->status!='approved' )
                   {
                   $return .= ' <button type="button" class="btn btn-danger btn-sm"
                                      data-toggle="modal" data-id="'.$leave->id.'" id="modaal" data-target="#modal-delete">
                                        <i class="fa fa-times-circle"></i>
                                        Delete
                                </button>';
                            }

                return $return;

           })


           ->setRowId('id')
            ->make(true);
    }

    public function dashboardListLeaves($id)
    {
         $date_format = Config::where('title','date_format')->first();

            $leaves = Leave::where('posted_for',$id)
                      ->with(['poster','applicant','action_taker','poster.roles'])
                      ->select('leaves.*','users.f_name','users.l_name')
                      ->join('users', 'leaves.posted_by', '=', 'users.id');




        return Datatables::of($leaves)

            ->editColumn('start_date', function ($leave) use($date_format) {

                return  date($date_format->key,strtotime($leave->start_date));
            })

            ->editColumn('end_date', function ($leave) use($date_format) {

                return  date($date_format->key,strtotime($leave->end_date));
            })

             ->editColumn('category', function ($leave) {
                if($leave->category=='short')
                    return  '<span class="badge bg-blue">Short</span>';
                else
                    return '<span class="badge bg-blue">Full Day</span>';
            })

            ->editColumn('created_at', function ($leave) use($date_format) {

                return  date($date_format->key,strtotime($leave->created_at));
            })

            ->editColumn('posted_by', function ($leave)  {
                if($leave->posted_by== $leave->posted_for)
                    return  '<button type="button" class="btn bg-gray-active  btn-sm">
                            <i class="fa fa-user"></i>
                                <span>'.$leave->poster->f_name.' '.$leave->poster->l_name.'</span>
                            </button>';
                else
                    return  '<button type="button" class="btn bg-gray-active  btn-sm">
                            <i class="fa fa-user"></i>
                                <span>'.$leave->poster->f_name.' '.$leave->poster->l_name.' ('.$leave->poster->roles[0]->name.')</span>
                            </button>';

            })



            ->addColumn('days', function ($leave){
                if($leave->category=='full')
                    return  '<span class="badge bg-blue">'.$leave->duration.'</span>';
                else
                    return  '---';

            })

            ->addColumn('hours', function ($leave){
                if($leave->category=='short')
                    return  '<span class="badge bg-blue">'.$leave->duration.'</span>';
                else
                    return  '---';

            })


            ->editColumn('status', function ($leave){
                 if($leave->status == 'pending')
                    return '<button class="btn btn-sm btn-warning" type="button">Pending</button>';
                if($leave->status == 'approved')
                    return '<button class="btn btn-sm btn-success" type="button">Approved</button>';
                if($leave->status == 'rejected')
                    return '<button class="btn btn-sm btn-danger" type="button">Rejected</button>';

            })


           ->setRowId('id')
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('employee::leave.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$this->validate($request,
            [
                'category' => 'required',

                  'type' => 'required',


            ]);


        if($request->category=='full')
        {
            $this->validate($request,
            [

                 'duration' => 'required',
                ]);
            $duration_arr = explode('-',$request->duration);

            ///$start_date = $duration_arr[0];
            //$end_date = $duration_arr[1];

            $start_date =date('Y-m-d',strtotime($duration_arr[0]));
            $end_date   = date('Y-m-d',strtotime($duration_arr[1]));
            $diff       =date_diff(date_create($start_date),date_create($end_date));

            if($diff->days==0)
                $duration = 1;
            else
            $duration = $diff->days;
        }

      if($request->category=='short')
        {
            $this->validate($request,
            [

                 'duration_short' => 'required',
                 'date' =>'required'
                ]);
             $start_date =date('Y-m-d',strtotime($request->date));
            $end_date   = date('Y-m-d',strtotime($request->date));

             $duration = $request->duration_short;
        }


        $leave = new Leave();

            $leave->posted_by = Auth::user()->id;
             $leave->posted_for = Auth::user()->id;





             $leave->status = 'pending';




         if($request->category=='full')
         {
            $leave->start_date = $start_date;

            $leave->end_date = $end_date;
        }

          if($request->category=='short')
         {
            $leave->start_date = $start_date;

            $leave->end_date = $end_date;
        }



        //$leave->poster_comments = $request->
        //$leave->approver_comments = $request->
        $leave->type = $request->type;
        $leave->category = $request->category;
        $leave->duration = $duration;
//dd($leave);
        $leave->save();

        // $arr['success'] = 'Leave added successfully';
        //return json_encode($arr);
       // exit;
        $request->session()->put('success', 'Leave added successfully!');
      	return redirect()->intended('admin/employee/leave');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
        $leave = Leave::findorFail($id);
        $leave->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        return redirect()->intended('admin/employee/leave');
    }

    function listLeaves()
    {
         $leaves = Leave::all();
         //dd($leaves);
          $route_delete = 'employee.leave.destroy';
         return view('employee::leave.index_all_leaves',compact('leaves','route_delete'));
    }
    function listPendingLeaves()
    {
         $leaves = Leave::where('status','pending')->with(['user', 'user.roles'])->get();
         //dd($leaves[0]->user->roles);
          $route_delete = 'employee.leave.destroy';
         return view('employee::leave.index_all_leaves',compact('leaves','route_delete'));
    }
    function listRejectedLeaves()
    {
         $leaves = Leave::where('status','rejected')->with(['user', 'user.roles'])->get();
         //dd($leaves);
          $route_delete = 'employee.leave.destroy';
         return view('employee::leave.index_all_leaves',compact('leaves','route_delete'));
    }

    function showCalendar()
    {

        $calendar   = new GoogleCalendar;

        //$result     = $calendar->get();
        $events_result     = $calendar->eventList();
       //dd($events_result);
        $events_arr = [];
         //while(true) {
        foreach ($events_result->getItems() as $event)
        {
           // dd($event);
            //$calendar->eventDelete($event->getId());
            if($event->start->getDatetime()!=NULL)
            {
                $events_arr[] = ['title'=>html_entity_decode ($event->getSummary()),
                             'start'=>$event->start->getDatetime(),
                             'end'=>$event->end->getDatetime(),
                             'description'=>$event->getDescription(),
                             'id'=>$event->getId()];
            }
            else
            {
                 $events_arr[] = ['title'=>html_entity_decode ($event->getSummary()),
                             'start'=>$event->start->getDate(),
                             'end'=>$event->end->getDate(),
                             'description'=>$event->getDescription(),
                             'id'=>$event->getId()];
            }
        }

        $events = json_encode($events_arr);
         return view('employee::leave.calendar',compact('events','route_delete'));
    }


    public function postCalander(Request $request)
    {
        // dd($request->all());
        $leave  = Leave::where('id', $request->leave_id)->with('user.employee')->first();
        $calendar   = new GoogleCalendar;
        $post = $calendar->eventPost(array(
              'summary' => $leave->user->f_name.' '.$leave->user->l_name.'('.$leave->user->roles[0]->display_name.') Leave: '.$leave->type.' ('.$leave->category.')',
              'location' => '',
              'visibility' => 'private',
              'description' => $leave->comments,
              'start' => array(
                'date' => $leave->start_date,
                'timeZone' => $leave->user->employee->time_zone,
              ),
              'end' => array(
                'date' => $leave->end_date,
                'timeZone' => $leave->user->employee->time_zone,
              ),
              'attendees' => array(
                array('email' => $leave->user->email),
                array('email' => Auth::user()->email),
              ),
              'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                  array('method' => 'email', 'minutes' => 24 * 60),
                  array('method' => 'popup', 'minutes' => 10),
                ),
              ),
            ));
            //dd($post->id);

            if($post)
            {

                $leave_update              = Leave::where('id',$request->leave_id)->first();
                $leave_update->status      = 'approved';
                $leave_update->google_post = 1;
                $leave_update->google_id   = $post->id;
                $leave_update->action_taken_by = Auth::user()->id;
                $leave_update->save();
            }

        $arr['success'] = 'Leave approved and posted to google calendar successfully';
        return json_encode($arr);
        exit;
            //exit;
        //return redirect()->intended('admin/employee/leave/calendar');
    }

    function rejectLeave(Request $request)
    {
        //dd($request->all());
         $leave_update              = Leave::where('id',$request->id)->first();
         $leave_update->status      = 'rejected';
         $leave_update->approved_by = Auth::user()->id;
         $leave_update->save();
         $arr['success']            = 'Leave rejected successfully';
         return json_encode($arr);
       exit;
        //return redirect()->intended('admin/employee/leave/pending_leaves');
    }


    function postLeaveForEmployee(Request $request)
    {

        $this->validate($request,
            [
                'category' => 'required',

                  'type' => 'required',


            ]);


        if($request->category=='full')
        {
            $this->validate($request,
            [

                 'duration' => 'required',
                ]);
            $duration_arr = explode('-',$request->duration);

            ///$start_date = $duration_arr[0];
            //$end_date = $duration_arr[1];

            $start_date =date('Y-m-d',strtotime($duration_arr[0]));
            $end_date   = date('Y-m-d',strtotime($duration_arr[1]));
            $diff       =date_diff(date_create($start_date),date_create($end_date));

            if($diff->days==0)
                $duration = 1;
            else
            $duration = $diff->days;
        }

      if($request->category=='short')
        {
            $this->validate($request,
            [

                 'duration_short' => 'required',
                ]);
             $start_date =date('Y-m-d',strtotime($request->date));
            $end_date   = date('Y-m-d',strtotime($request->date));
             $duration = $request->duration_short;
        }


        $leave = new Leave();
        if(Auth::user()->id == $request->employee_id)
            $leave->posted_by = $request->employee_id;
        else
        {
            $leave->posted_by = $request->posted_by;
            $leave->posted_for = $request->employee_id;
        }

        if(Auth::user()->id != $request->employee_id && isset($request->status))
        {
            $leave->status = $request->status;
           $leave->action_taken_by = Auth::user()->id;

        }
        else
             $leave->status = 'pending';





         if($request->category=='full')
         {
            $leave->start_date = $start_date;

            $leave->end_date = $end_date;
        }

          if($request->category=='short')
         {
            $leave->start_date = $start_date;

            $leave->end_date = $end_date;
        }



        //$leave->poster_comments = $request->
        //$leave->approver_comments = $request->
        $leave->type = $request->type;
        $leave->category = $request->category;
        $leave->duration = $duration;

        $leave->save();
          $arr['success'] = 'Leave added successfully';
        return json_encode($arr);
        exit;


    }
}
