<?php
namespace App\Modules\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\Product;
use App\Modules\Crm\Http\CustomerServiceType;
use App\Modules\Crm\Http\DefaultRate;
use App\Modules\Crm\Http\CustomerBillingPeriod;
use App\Modules\Crm\Http\CustomerServiceItem;
use App\Modules\Crm\Http\CustomerServiceRate;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Crm\Http\CustomerNote;
use App\Modules\Crm\Http\Invoice;
use App\Modules\Crm\Http\Country;
use App\Services\GoogleCalendar;

use App\Modules\Crm\Http\CustomerLocationContact;

use App\Modules\Crm\Http\CustomerAppointment;
use App\Model\Config;

use App\Model\Role;
use App\Model\User;
use Auth;
use URL;
use Datatables;

use Session;

class AppointmentController extends Controller
{

    function postEvent(Request $request)
    {


        $panctuality[0] = 'As scheduled' ;
        $panctuality[1] = '1 Hour Window' ;
        $panctuality[2] = '2 Hour Window' ;
        $panctuality[3] = '3 Hour Window' ;
        $panctuality[4] = 'Same Day' ;
        $panctuality[5] = 'Tentative' ;

        
        $location = CustomerLocation::find($request->location_index);
        $technician = User::find($request->employee_index);
        $contact = CustomerLocationContact::find($request->contact_index);
        $service = CustomerServiceItem::find($request->appointment_against) ;

        $timeframe = ' &#177; '.$request->timeframe;
        if ($request->timeframe==4) {
            $timeframe = 'SDY';
        }

        if ($request->timeframe==5) {
            $timeframe = 'TTV';
        }

        $date_arr = explode(',', $request->calander_data);
     

        $calendar   = new GoogleCalendar;
       
        $description = 'Location : '.$location->location_name;
        $description .= ' Technician : '.$technician->f_name.' '.$technician->l_name;
        $description .= ' Contact : '.$contact->f_name.' '.$contact->l_name;
        $description .= ' Punctuality : '.$panctuality[$request->timeframe];
        if ($service) {
            $description .= ' Against : '.$service->title;
        }
        $description .= ' Start time : '.date("H:i:s", strtotime($date_arr[0]));
        $description .= ' End time : '.date("H:i:s", strtotime($date_arr[1]));

        $description .= ' Notes : '.$request->notes;


        $startDateTime = new \DateTime($date_arr[0], new \DateTimeZone($this->time_zone));

        $start = $startDateTime->format(\DateTime::ISO8601);

        $endDateTime = new \DateTime($date_arr[1], new \DateTimeZone($this->time_zone));

        $end = $endDateTime->format(\DateTime::ISO8601);
       
        $post = $calendar->eventPost([
              'summary' =>  html_entity_decode('@'.$technician->f_name.' '.$timeframe.' '.$request->appointment_title),
              'location' => $location->address.' '.$location->city.' '.$location->state.' '.$location->zip,
              'visibility' => 'private',
              'description' =>  $description,
              'start' => [
                'dateTime' => $start,
                'timeZone' => $this->time_zone,
              ],
              'end' => [
                'dateTime' => $end,
                'timeZone' => $this->time_zone,
              ],
              'reminders' => [
                'useDefault' => false,
                'overrides' => [
                  ['method' => 'email', 'minutes' => 24 * 60],
                  ['method' => 'popup', 'minutes' => 10],
                ],
              ],
            ]);
            //dd($post);
            $appointment              = new CustomerAppointment;
            $appointment->customer_id = Session::get('cust_id');
            $appointment->created_by  = Auth::user()->id;
            $appointment->customer_location_id = $location->id;
            $appointment->technician_id = $technician->id;
            $appointment->customer_location_contact_id = $contact->id;
            $appointment->title = $request->appointment_title;
            $appointment->panctuality = $request->timeframe;
            $appointment->notes = $request->notes;
            $appointment->event_date = date('Y-m-d', strtotime($date_arr[0]));
        if ($service) {
            $appointment->customer_service_item_id = $service->id;
        }
            $appointment->event_id_google = $post->id;
            $appointment->save();

        $arr['success'] ='yes';
        $arr['msg'] = 'Appointment posted to google calendar successfully';
        return json_encode($arr);
        exit;
    }
   

    function updateEvent(Request $request)
    {
     //dd($request->all());

        $event_id = $request->google_event_id;

        $panctuality[0] = 'As scheduled' ;
        $panctuality[1] = '1 Hour Window' ;
        $panctuality[2] = '2 Hour Window' ;
        $panctuality[3] = '3 Hour Window' ;
        $panctuality[4] = 'Same Day' ;
        $panctuality[5] = 'Tentative' ;

        
        $location = CustomerLocation::find($request->location_index);
        $technician = User::find($request->employee_index);
        $contact = CustomerLocationContact::find($request->contact_index);
        $service = CustomerServiceItem::find($request->appointment_against) ;

        $timeframe = ' &#177; '.$request->timeframe;
        if ($request->timeframe==4) {
            $timeframe = 'SDY';
        }

        if ($request->timeframe==5) {
            $timeframe = 'TTV';
        }

        $date_arr = explode(',', $request->calander_data);
       

        $startDateTime = new \DateTime($date_arr[0], new \DateTimeZone($this->time_zone));

        $start = $startDateTime->format(\DateTime::ISO8601);

        $endDateTime = new \DateTime($date_arr[1], new \DateTimeZone($this->time_zone));

        $end = $endDateTime->format(\DateTime::ISO8601);

        

        $calendar   = new GoogleCalendar;
        $description = 'Location : '.$location->location_name;
        $description .= ' Technician : '.$technician->f_name.' '.$technician->l_name;
        $description .= ' Contact : '.$contact->f_name.' '.$contact->l_name;
        $description .= ' Punctuality : '.$panctuality[$request->timeframe];
        if ($service) {
            $description .= ' Against : '.$service->title;
        }
        $description .= ' Start time : '.date("H:i:s", strtotime($date_arr[0]));
        $description .= ' End time : '.date("H:i:s", strtotime($date_arr[1]));

        $description .= ' Notes : '.$request->notes;


        $post = $calendar->eventUpdate($event_id, [
              'summary' =>  html_entity_decode('@'.$technician->f_name.' '.$timeframe.' '.$request->appointment_title),
              'location' => $location->address.' '.$location->city.' '.$location->state.' '.$location->zip,
              'visibility' => 'private',
              'description' => $description,
              'start' => [
                'dateTime' => $start,
                'timeZone' => $this->time_zone,
              ],
              'end' => [
                'dateTime' => $end,
                'timeZone' => $this->time_zone,
              ],
             
              'reminders' => [
                'useDefault' => false,
                'overrides' => [
                  ['method' => 'email', 'minutes' => 24 * 60],
                  ['method' => 'popup', 'minutes' => 10],
                ],
              ],
            ]);
             
            $appointment              =  CustomerAppointment::where('event_id_google', $event_id)->first();
           
            $appointment->created_by  = Auth::user()->id;
            $appointment->customer_location_id = $location->id;
            $appointment->technician_id = $technician->id;
            $appointment->customer_location_contact_id = $contact->id;
            $appointment->title = $request->appointment_title;
            $appointment->panctuality = $request->timeframe;
            $appointment->notes = $request->notes;
            $appointment->event_date = date('Y-m-d', strtotime($date_arr[0]));
        if ($service) {
            $appointment->customer_service_item_id = $service->id;
        }
            $appointment->event_id_google = $post->id;
            $appointment->save();

        $arr['success'] ='yes';
        $arr['msg'] = 'Appointment posted to google calendar successfully';
        return json_encode($arr);
        exit;
    }

    function getAppointmentById($id)
    {
        $appointment = CustomerAppointment::where('event_id_google', $id)->first();

        return json_encode($appointment);
        exit;
    }

    function getEventById($id)
    {
        $calendar   = new GoogleCalendar;

        $event = $calendar->event($id);

        $arr[] = ['title'=>html_entity_decode($event->getSummary()),
                             'start'=>$event->start->getDatetime(),
                             'end'=>$event->end->getDatetime()];
        return json_encode($arr);
        exit;
    }


    function editEvent($id, $cust_id)
    {
        return View('admin.appointment_edit', compact('id', 'cust_id'));
    }

    function deleteEvent(Request $request)
    {
        $eve_id = $request->event_id;
     // $app_id = $request->app_id;

        $calendar   = new GoogleCalendar;

        $event = $calendar->eventDelete($eve_id);
        CustomerAppointment::where('event_id_google', $eve_id)->delete();

        $arr['success']='yes';

        return json_encode($arr);
        exit;
    }
}
