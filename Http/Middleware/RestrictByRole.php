<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RestrictByRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
public function handle($request, Closure $next)
{
  $roles = $this->getRoles($request);

  $role = Auth::user()->role;
  if ($role == 'admin') {
    return $next($request);
  }
  elseif ( !in_array($role, $roles) ) {
    return response('Unauthorized.', 401);
  }
 
  return $next($request);
}

 /**
     * Grab the roles from the request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Array
     */
    private function getRoles($request)
    {
        $actions = $request->route()->getAction();
        return $actions['roles'];
    }
}
