<?php
namespace App\Modules\Employee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Employee\Http\Employee;
use App\Modules\Employee\Http\Requests\RaisePostRequest;
use App\Model\Role;
use App\Model\User;
use App\Modules\Employee\Http\Raise;

class RaiseController extends Controller
{
    private $controller = 'raise';
    

    public function index()
    {
       
        $controller = $this->controller;
        $employees = User::where('type', 'employee')->get();

        return view('employee::admin.index', compact('employees', 'controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RaisePostRequest $request)
    {
        $raise = new Raise;
        $raise->effective_date = date("Y-m-d", strtotime($request->effective_date));
        $raise->old_pay = $request->old_pay;
       
        $raise->new_pay = $request->new_pay;
        $raise->user_id = $request->user_id;
        $raise->notes = $request->notes;
        $raise->save();
        //return redirect()->intended('admin/employee');
        $arr['success'] = 'Record added sussessfully';
        echo json_encode($arr);
        exit;
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
    public function edit($id)
    {
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
        $raise = Raise::findorFail($id);
      
        $raise->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        //return redirect()->intended('admin/employee');
        $arr['success'] = 'Record Deleted sussessfully';
        echo json_encode($arr);
        exit;
    }


    private function timezone_list()
    {
        static $timezones = null;

        if ($timezones === null) {
            $timezones = [];
            $offsets = [];
            $now = new \DateTime();
            foreach (\DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, 'US') as $timezone) {
                $now->setTimezone(new \DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $timezones[$timezone] = '(' . $this->format_GMT_offset($offset) . ') ' . $this->format_timezone_name($timezone);
            }

            array_multisort($offsets, $timezones);
        }

        return $timezones;
    }

    private function format_GMT_offset($offset)
    {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    private function format_timezone_name($name)
    {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }
}
