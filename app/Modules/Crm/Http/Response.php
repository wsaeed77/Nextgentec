<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
   
   
public function responder()
    {
        return $this->belongsTo('App\Model\User','responder_id');
    }

   
    
}
