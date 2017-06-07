<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';


   /*  public function assigned_tickets()
    {
        return $this->hasMany('App\Modules\Crm\Http\Ticket','created_by');
    }*/
}
