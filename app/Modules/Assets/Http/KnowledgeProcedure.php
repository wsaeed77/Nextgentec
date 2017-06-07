<?php

namespace App\Modules\Assets\Http;

use Illuminate\Database\Eloquent\Model;

class KnowledgeProcedure extends Model
{

   function customer()
   {

   	return $this->belongsTo('App\Modules\Crm\Http\Customer');
   }


}
