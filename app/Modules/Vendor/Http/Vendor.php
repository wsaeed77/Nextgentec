<?php

namespace App\Modules\Vendor\Http;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{

    public function customers()
    {
        return $this->belongsToMany('App\Modules\Crm\Http\Customer')->withTimestamps()
        ->withPivot('id', 'auth_contact_name', 'phone_number', 'account_number', 'portal_url', 'notes', 'location_id');
    }

    public function contacts()
    {
        return $this->hasMany('App\Modules\Vendor\Http\VendorContact');
    }

    public function vend_cust_loc()
    {
        return $this->belongsToMany('App\Modules\Crm\Http\CustomerLocation', 'customer_vendor', 'vendor_id', 'location_id');
    }
    public function location()
    {
        return $this->belongsToMany('App\Modules\Crm\Http\CustomerLocation', 'customer_vendor', 'vendor_id', 'location_id');
    }
    public function password()
    {
        return $this->hasOne('App\Modules\Assets\Http\KnowledgePassword', 'vendor_id');
    }

   
    //cascading password delete with vendor delete
   /*protected static function boot() {
        parent::boot();

        static::deleting(function($vendor) { // before delete() method call this
             $vendor->password()->delete();
             // do the rest of the cleanup...
        });
    }*/
}
