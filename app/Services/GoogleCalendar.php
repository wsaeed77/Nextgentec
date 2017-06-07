<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class GoogleCalendar
{

    protected $client;

    protected $service;
    protected $event;
    protected $calendarId;

    function __construct()
    {
        /* Get config variables */
        $client_id = Config::get('google.client_id');
        $this->calendarId = Config::get('google.calendar_id');
        $service_account_name = Config::get('google.service_account_name');
        $key_file_location = base_path() . Config::get('google.key_file_location');

        $this->client = new \Google_Client();
        $this->client->setApplicationName("google-calander");
        $this->service = new \Google_Service_Calendar($this->client);



        /* If we have an access token */
        if (Cache::has('service_token')) {
            $this->client->setAccessToken(Cache::get('service_token'));
        }

        $key = file_get_contents($key_file_location);
        /* Add the scopes you need */
        $scopes = ['https://www.googleapis.com/auth/calendar'];
        $cred = new \Google_Auth_AssertionCredentials(
            $service_account_name,
            $scopes,
            $key
        );

        $this->client->setAssertionCredentials($cred);
        if ($this->client->getAuth()->isAccessTokenExpired()) {
            $this->client->getAuth()->refreshTokenWithAssertion($cred);
        }
        Cache::forever('service_token', $this->client->getAccessToken());
    }

    public function get()
    {
        $results = $this->service->calendars->get($this->calendarId);
        return($results);
    }

    function eventPost($data)
    {
        $event = new \Google_Service_Calendar_Event($data);

        $event = $this->service->events->insert($this->calendarId, $event);
        //printf('Event created: %s\n', $event->htmlLink);
        if ($event) {
            return $event;
        }
    }
    function eventList($startDate = null, $endDate = null)
    {
        $params = [];
        if (isset($startDate)) {
            $params['timeMin'] = $startDate . 'T00:00:00-05:00';
        }
        if (isset($endDate)) {
            $params['timeMax'] = $endDate . 'T23:59:59-05:00';
        }

        $events = $this->service->events->listEvents($this->calendarId, $params);
        return $events;
    }


    function event($id)
    {

        $event = $this->service->events->get($this->calendarId, $id);
        return $event;
    }
    function eventDelete($event_id)
    {
        $this->service->events->delete($this->calendarId, $event_id);
        //$events = $this->service->events->listEvents($this->calendarId);

        return true;
    }

    function eventUpdate($eventId, $data)
    {
            $event = $this->service->events->get($this->calendarId, $eventId);

            

            $event->setSummary($data['summary']);
            $event->setLocation($data['location']);
            $event->setDescription($data['description']);
            $event->start->setDatetime($data['start']['dateTime']);
            $event->start->setTimezone($data['start']['timeZone']);
            $event->end->setDatetime($data['end']['dateTime']);
            $event->end->setTimezone($data['end']['timeZone']);
            //$event->setAttendees($data['attendees']);
           

            $updatedEvent = $this->service->events->update($this->calendarId, $event->getId(), $event);

            // Print the updated date.
            //return $updatedEvent->getUpdated();
            return $updatedEvent;
            //return true;
    }
}
