<?php

namespace App\Modules\Backupmanager\Http;

use Illuminate\Database\Eloquent\Model;

class Script extends Model
{
  protected $table = 'backupmanager_scripts';

   public function scriptBody() {
    return $this->hasOne('App\Modules\Backupmanager\Http\ScriptBody', 'id', 'script_body_id');
  }
}
