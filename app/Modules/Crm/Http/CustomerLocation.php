<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class CustomerLocation extends Model
{
  
    public function customer()
    {
        return $this->belongsTo('App\Modules\Crm\Http\Customer');
    }

    public function contacts()
    {
        return $this->hasMany('App\Modules\Crm\Http\CustomerLocationContact');
    }

    public function networks()
    {
        return $this->hasMany('App\Modules\Assets\Http\Network');
    }


    public function vend_cust_loc()
    {
        return $this->hasMany('App\Modules\Vendor\Http\VendorCustomer', 'location_id');
    }
}
