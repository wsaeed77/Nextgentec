<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class CustomerBillingPeriod extends Model
{
    //

    public function customer()
    {
        return $this->belongsTo('App\Modules\Crm\Http\Customer');
    }
    
    public function service_item()
    {
        return $this->hasOne('App\Modules\Crm\Http\CustomerServiceItem');
    }
}
