<?php

namespace App\Listeners;

use App\Events\countNewLeaves;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\Employee\Http\Leave;
class CalculateNewLeavesPosted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  countNewLeaves  $event
     * @return void
     */
    public function handle(countNewLeaves $event)
    {
        $leaves_count = Leave::where('status','pending')->where('google_post',0)->count();
        return $leaves_count;
    }
}
