<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ( $this->isAdmin() ){
            return $next($request);
        }else{
            return abort(403, "Unauthorized access! You haven't right to access this");
        }

    }

    function isAdmin()
    {
        $role = DB::table('roles')
            ->select('roles.*')
            ->where('roles.id', '=', Auth::user()->role_id)
            ->first();
        if ($role->name == 'admin') {
            return true;
        } else {
            return false;
        }
    }
}
