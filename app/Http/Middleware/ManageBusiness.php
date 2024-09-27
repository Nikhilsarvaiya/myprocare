<?php

namespace App\Http\Middleware;

use App\Models\Business;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManageBusiness
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->business instanceof Business) {
            $business = $request->business;
        } else {
            $business = Business::query()->where('id', '=', $request->route()->parameter('business'))->firstOrFail();
        }

        if ($request->user()->hasRole('admin') || Auth::id() === $business->user_id){
            return $next($request);
        }else{
            abort(Response::HTTP_UNAUTHORIZED);
        }
    }
}
