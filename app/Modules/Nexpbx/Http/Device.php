<?php

namespace App\Modules\Nexpbx\Http;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
  protected $table = 'nexpbx_devices';

   public function domain() {
    return $this->belongsTo('App\Modules\Nexpbx\Http\Domain','domain_uuid','domain_uuid');
  }

  public function location() {
    return $this->belongsTo('App\Modules\Crm\Http\CustomerLocation','location_id','id');
  }
}
