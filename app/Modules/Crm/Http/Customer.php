<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    public function service_items()
    {
        return $this->hasMany('App\Modules\Crm\Http\CustomerServiceItem');
    }

   /* public function billing_periods()
    {
        return $this->hasMany('App\Modules\Crm\Http\CustomerBillingPeriod');
    }*/

    public function locations()
    {
        return $this->hasMany('App\Modules\Crm\Http\CustomerLocation');
    }

    public function tickets()
    {
        return $this->hasMany('App\Modules\Crm\Http\Ticket');
    }

    public function default_rates()
    {
        return $this->hasMany('App\Modules\Crm\Http\DefaultRate');
    }

    public function assets()
    {
        return $this->hasMany('App\Modules\Assets\Http\Asset');
    }

    public function notes()
    {
         return $this->hasMany('App\Modules\Crm\Http\CustomerNote');
    }

    public function vendors()
    {
        return $this->belongsToMany('App\Modules\Vendor\Http\Vendor', 'customer_vendor', 'customer_id', 'vendor_id')->withTimestamps()
        ->withPivot('id', 'location_id', 'auth_contact_name', 'phone_number', 'account_number', 'portal_url', 'notes');
    }

   

    public function products()
    {
        return $this->belongsToMany('App\Modules\Crm\Http\Product');
    }

    public function invoices()
    {
        return $this->hasMany('App\Modules\Crm\Http\Invoice');
    }

    public function vend_cust_loc1()
    {
        return $this->belongsToMany('App\Modules\Crm\Http\CustomerLocation', 'customer_vendor', 'id', 'location_id');
    }

    public function domain()
    {
        return $this->hasOne('App\Modules\Nexpbx\Http\Domain');
    }
}
