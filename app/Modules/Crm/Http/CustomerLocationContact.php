<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class CustomerLocationContact extends Model
{
  

	public function location()
    {
    	return $this->belongsTo('App\Modules\Crm\Http\CustomerLocation');
        
    }

  

 
}
