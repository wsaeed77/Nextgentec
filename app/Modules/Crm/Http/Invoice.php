<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = ['id'];
  
    public function customer()
    {
        return $this->belongsTo('App\Modules\Crm\Http\Customer', 'customer_id');
    }
}
