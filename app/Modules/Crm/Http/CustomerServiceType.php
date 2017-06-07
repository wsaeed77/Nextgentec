<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class CustomerServiceType extends Model
{
  

public function service_items()
    {
        return $this->hasOne('App\Modules\Crm\Http\CustomerServiceItem','service_type_id');
    }

     public function delete()
    {
        $this->service_items()->delete();
       
        return parent::delete();
    }
 
}
