<?php

namespace App\Modules\Assets\Http;

use Illuminate\Database\Eloquent\Model;

class KnowledgeSerialNumber extends Model
{

   function customer()
   {

   	return $this->belongsTo('App\Modules\Crm\Http\Customer');
   }
   function location()
   {

   	return $this->belongsTo('App\Modules\Crm\Http\CustomerLocation','location_id');
   }

}
