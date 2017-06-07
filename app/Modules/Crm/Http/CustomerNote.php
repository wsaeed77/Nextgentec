<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model
{

    public function customer()
    {
        return $this->belongsTo('App\Modules\Crm\Http\Customer', 'customer_id');
    }

    public function entered_by()
    {
        return $this->belongsTo('App\Model\User', 'created_by');
    }
}
