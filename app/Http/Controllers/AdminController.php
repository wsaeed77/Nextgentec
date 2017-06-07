<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignUpPostRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Model\User;
use Auth;
use Event;
use App\Events\countNewLeaves;
use App\Events\updateGoogleAuthToken;
use App\Services\GoogleCalendar;
use Session;
use App\Modules\Crm\Http\CustomerAppointment;
class AdminController extends Controller
{
    //private $admin = 1;

 use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    private $admin = 1;
        /**
         * Setup the layout used by the controller.
         */
        public function __construct()
        {
        }

    public function getRegister()
    {
        return view('admin.register');
    }

    public function postRegister(SignUpPostRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->intended('admin/dashboard');
    }

    public function getLogin()
    {
        // If logged in redirect
        if (Auth::check())
          return redirect()->intended('admin/dashboard');

        // Not logged in
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
          'email' => 'required|email',
            'password' => 'required',
       ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (Auth::user()->hasRole('admin')) {
                $leaves_count = Event::fire(new countNewLeaves());
                //Event::fire(new updateGoogleAuthToken());
                Session::forget('leaves_posted_count');
                Session::put('leaves_posted_count', $leaves_count[0]);
            }
                     //dd($leaves_count);
                return redirect()->intended('admin/dashboard');
        } else {
            return redirect()->intended('admin/login');
        }
    }

    public function showDashboard()
    {
      /*$calendar   = new GoogleCalendar;
      $events_result     = $calendar->eventList();
      $events_arr = [];

      foreach ($events_result->getItems() as $event)
      {
          //dd($event->organizer);
          //$calendar->eventDelete($event->getId());
          if($event->start->getDatetime()!=NULL)
          {
              $events_arr[] = ['title'=>$event->getSummary(),
                           'start'=>$event->start->getDatetime(),
                           'end'=>$event->end->getDatetime()];
          }
          else
          {
               $events_arr[] = ['title'=>$event->getSummary(),
                           'start'=>$event->start->getDate(),
                           'end'=>$event->end->getDate()];
          }
      }

      $events = json_encode($events_arr);*/

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
          
          $event_row = CustomerAppointment::where('event_id_google',$event->getId())->first();
          //dd($event_row);
          if(!$event_row)
            $event_row='';

            if($event->start->getDatetime()!=NULL)
            {
                $events_arr[] = ['title'=>html_entity_decode ($event->getSummary()),
                             'start'=>$event->start->getDatetime(),
                             'end'=>$event->end->getDatetime(),
                             'description'=>$event->getDescription(),
                             'id'=>$event->getId(),
                             'event_row'=>$event_row];
            }
            else
            {
                 $events_arr[] = ['title'=>html_entity_decode ($event->getSummary()),
                             'start'=>$event->start->getDate(),
                             'end'=>$event->end->getDate(),
                             'description'=>$event->getDescription(),
                             'id'=>$event->getId(),
                             'event_row'=>$event_row];
            }
        }

        $events = json_encode($events_arr);
       ///dd($events_arr);                    
      session()->forget('cust_id');
      session()->forget('customer_name');
      return View('admin.dashboard',compact('events'));
    }

    public function doLogout()
    {
        Auth::logout(false); // log the user out of our application
            return Redirect::to('admin'); // redirect the user to the login screen
    }

    public function profile()
    {
    }
    public function listUsers()
    {
        $user = User::where('role_id', '<>', $this->admin)->get();
            //$role = $user->role;

            /*foreach($user as $usr)
            {
                echo $usr->name;
            }*/
            //exit;
            return view('admin.users', ['users' => $user]);
    }

    public function addUser()
    {
        return view('admin.add_user');
    }

    public function postAddUser(SignUpPostRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = 2;
        $user->save();

        return redirect()->intended('admin/users');
    }

}
