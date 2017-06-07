<?php

namespace App\Modules\Assets\Http;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{

    public function location()
    {
        return $this->belongsTo('App\Modules\Crm\Http\CustomerLocation', 'customer_location_id');
    }
}
