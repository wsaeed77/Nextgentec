<?php

namespace App\Modules\Assets\Http;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $fillable = ['title'];

    function password()
    {

        return $this->belongsToMany('App\Modules\Assets\Http\KnowledgePassword')->withTimestamps();
    }
}
