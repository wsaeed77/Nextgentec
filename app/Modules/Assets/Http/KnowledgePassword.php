<?php

namespace App\Modules\Assets\Http;

use Illuminate\Database\Eloquent\Model;

class KnowledgePassword extends Model
{

   function customer()
   {

   	return $this->belongsTo('App\Modules\Crm\Http\Customer');
   }

   function tags()
   {

   	return $this->belongsToMany('App\Modules\Assets\Http\Tag')->withTimestamps();
   }


   function asset()
   {

   	return $this->belongsTo('App\Modules\Assets\Http\Asset','asset_id');
   }
   function vendor()
   {

      return $this->belongsTo('App\Modules\Vendor\Http\Vendor','vendor_id');
   }


   
}
