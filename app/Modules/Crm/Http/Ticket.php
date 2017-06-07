<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    public function responses()
    {
        return $this->hasMany('App\Modules\Crm\Http\Response');
    }

    public function attachments()
    {
        return $this->hasMany('App\Modules\Crm\Http\Attachment');
    }

   /* public function billing_periods()
    {
        return $this->hasMany('App\Modules\Crm\Http\CustomerBillingPeriod');
    }*/

   public function assigned_to()
    {
        return $this->belongsToMany('App\Model\User')->withTimestamps();
    }

    public function entered_by()
    {
        return $this->belongsTo('App\Model\User','created_by');
    }

    public function location()
    {
        return $this->belongsTo('App\Modules\Crm\Http\CustomerLocation','location_id');
    }

    public function service_item()
    {
        return $this->belongsTo('App\Modules\Crm\Http\CustomerServiceItem','service_item_id');
    }
   

    public function customer_contact()
    {
        return $this->belongsTo('App\Modules\Crm\Http\CustomerLocationContact','customer_location_contact_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Modules\Crm\Http\Customer');
    }
   
    public function status()
    {
        return $this->belongsTo('App\Modules\Crm\Http\TicketStatus','ticket_status_id');
    }

    

    
}
