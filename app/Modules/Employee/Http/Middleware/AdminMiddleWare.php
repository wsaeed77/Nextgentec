<?php

namespace App\Modules\Employee\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminMiddleWare
{
  
protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd($this->auth->guest());
        if ($this->auth->guest()) {
            //echo 'ffd';
            //exit;
            return redirect()->guest('admin/login');
        }
        
        return $next($request);
    }
}
