<?php

namespace App\Http\Middleware;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Entrust;

class EntrustAbility
{
    protected $auth;
    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @param $roles
     * @param $permissions
     * @param bool $validateAll
     * @return mixed
     */
    public function handle($request, Closure $next, $roles, $permissions, $validateAll = false)
    {
        $roles          = explode('|', $roles);
        $permissions    = explode('|', $permissions);

        // check for edit-profile permission
        if (in_array("edit-profile", $permissions) /*&& Entrust::may('edit-profile')*/) {
            // get route information
            $route = $request->route();
            $paramNames = $route->parameterNames();
            $id = null;
            if (!empty($paramNames) && isset($paramNames[0])) {
                $id = $request->route()->getParameter($paramNames[0]);
            }

            // check user 
            if (!is_null($id) && $id == $request->user()->id) {
                return $next($request);
            }
        }

        if ($this->auth->guest() || !$request->user()->ability($roles, $permissions, array('validate_all' => $validateAll))) {
            return response('Forbidden: You are not authorized to access this resource.', 403);
        }

        return $next($request);
    }
}
