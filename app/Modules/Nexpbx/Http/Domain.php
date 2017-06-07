<?php

namespace App\Modules\Nexpbx\Http;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
  protected $table = 'nexpbx_domains';

  public function devices() {
    return $this->hasmany('App\Modules\Nexpbx\Http\Device','domain_uuid','domain_uuid');
  }

   public function customer() {
    return $this->belongsTo('App\Modules\Crm\Http\Customer');
  }
}
