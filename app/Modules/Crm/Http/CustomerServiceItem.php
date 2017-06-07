<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class CustomerServiceItem extends Model
{
  public function rates()
    {
        return $this->hasMany('App\Modules\Crm\Http\CustomerServiceRate');
    }


	public function service_type()
    {
    	return $this->belongsTo('App\Modules\Crm\Http\CustomerServiceType');
        
    }


    public function billing_period()
    {
    	return $this->belongsTo('App\Modules\Crm\Http\CustomerBillingPeriod');
        
    }

 protected static function boot() {
        parent::boot();

        static::deleting(function($serviceitem) { 
             // before delete() method call this
             $serviceitem->rates()->delete();
             
        });
    }
 
}
