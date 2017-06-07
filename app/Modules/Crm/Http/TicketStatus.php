<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class TicketStatus extends Model
{
   
   
public function tickets()
    {
        return $this->hasMany('App\Modules\Crm\Http\Ticket');
    }

   
    
}
