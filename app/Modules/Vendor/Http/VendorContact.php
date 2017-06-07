<?php

namespace App\Modules\Vendor\Http;

use Illuminate\Database\Eloquent\Model;

class VendorContact extends Model
{

	 public function contacts()
    {
        return $this->belongsTo('App\Modules\Vendor\Http\Vendor');
    }


  

}
