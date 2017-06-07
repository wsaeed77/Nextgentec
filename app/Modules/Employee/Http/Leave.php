<?php

namespace App\Modules\Employee\Http;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public function poster()
    {
        return $this->belongsTo('App\Model\User', 'posted_by');
    }

    public function applicant()
    {
        return $this->belongsTo('App\Model\User', 'posted_for');
    }

    public function action_taker()
    {
        return $this->belongsTo('App\Model\User', 'action_taken_by');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'posted_for');
    }
}
