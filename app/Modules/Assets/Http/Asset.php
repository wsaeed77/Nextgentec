<?php

namespace App\Modules\Assets\Http;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{

    function customer()
    {
        return $this->belongsTo('App\Modules\Crm\Http\Customer');
    }

    function location()
    {
        return $this->belongsTo('App\Modules\Crm\Http\CustomerLocation', 'location_id');
    }


    function virtual_type()
    {
        return $this->belongsTo('App\Modules\Assets\Http\AssetVirtualType', 'asset_virtual_type_id');
    }

    public function password()
    {
        return $this->hasOne('App\Modules\Assets\Http\KnowledgePassword', 'asset_id');
    }
}
