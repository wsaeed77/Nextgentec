<?php

namespace App\Modules\Assets\Http;

use Illuminate\Database\Eloquent\Model;

class AssetVirtualType extends Model
{

   public function assets()
    {
        return $this->hasMany('App\Modules\Assets\Http\Asset');
    }

}
