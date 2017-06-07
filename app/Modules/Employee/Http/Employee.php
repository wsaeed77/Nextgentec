<?php

namespace App\Modules\Employee\Http;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //protected $table = 'employees';


     public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    
    
    
}
