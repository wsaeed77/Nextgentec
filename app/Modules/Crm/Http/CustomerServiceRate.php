<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class CustomerServiceRate extends Model
{
  

    public function service_item()
    {
        return $this->belongsTo('App\Modules\Crm\Http\CustomerServiceItem');
    }
}
