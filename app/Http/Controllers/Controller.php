<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Model\Config;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $global_date;
    public $global_time;
    public $global_phone_number_mask;
    public $global_mobile_number_mask;
    public $global_fax_number_mask;
    public $time_zone;
    public $user;

    function __construct()
    {

        $global_date = Config::where('title', 'date_format')->first();
        $global_time = Config::where('title', 'time_format')->first();
        $global_phone_number_mask = Config::where('key', 'telephone')->first();
        $global_mobile_number_mask = Config::where('key', 'mobile')->first();
        $global_fax_number_mask = Config::where('key', 'fax')->first();
        $global_time_zone = Config::where('key', 'system_timezone')->first();
       

        if ($global_time_zone) {
            $this->time_zone = $global_time_zone->value;
        } else {
            $this->time_zone = 'America/New_York';
        }
      //dd($global_time_zone->value);
        if ($global_date) {
            $this->global_date = $global_date->key;
        } else {
            $this->global_date = 'm/d/Y';
        }

        if ($global_phone_number_mask) {
            $this->global_phone_number_mask = $global_phone_number_mask->value;
        } else {
            $this->global_phone_number_mask = '(999) 999-9999';
        }

        if ($global_mobile_number_mask) {
            $this->global_mobile_number_mask = $global_mobile_number_mask->value;
        } else {
            $this->global_mobile_number_mask = '(999) 999-9999';
        }

        if ($global_fax_number_mask) {
            $this->global_fax_number_mask = $global_fax_number_mask->value;
        } else {
            $this->global_fax_number_mask = '(999) 999-9999';
        }


        \View::share('global_date', $this->global_date);
        \View::share('global_time', $global_time);

        \View::share('js_global_date', $global_date->value);
        \View::share('global_time_zone', $this->time_zone);
        \View::share('global_phone_number_mask', $this->global_phone_number_mask);
        \View::share('global_mobile_number_mask', $this->global_mobile_number_mask);
        \View::share('global_fax_number_mask', $this->global_fax_number_mask);
    }
}
