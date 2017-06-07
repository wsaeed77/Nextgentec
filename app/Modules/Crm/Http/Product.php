<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function assigned_tickets()
    {
        return $this->belongsToMany('App\Modules\Crm\Http\Customer');
    }
}
