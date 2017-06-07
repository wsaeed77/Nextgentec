<?php

namespace App\Modules\Vendor\Http;

use Illuminate\Database\Eloquent\Model;

class VendorCustomerLocation extends Model
{
    protected $table = 'customer_vendor';

    public function vendor()
    {
        return $this->belongsTo('App\Modules\Vendor\Http\Vendor', 'vendor_id');
    }

    public function customer()
    {
         return $this->belongsTo('App\Modules\Crm\Http\Customer', 'customer_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Modules\Crm\Http\CustomerLocation', 'location_id');
    }
}
