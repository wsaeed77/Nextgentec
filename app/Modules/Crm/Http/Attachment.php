<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
   
   
    public function ticket()
    {
        return $this->belongsTo('App\Modules\Crm\Http\Ticket','location_id');
    }

   
   


    
}
