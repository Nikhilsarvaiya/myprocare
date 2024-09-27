<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManageMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->menu instanceof Menu) {
            $menu = $request->menu;
        } else {
            $menu = Menu::query()->where('id', '=', $request->route()->parameter('menu'))->firstOrFail();
        }

        if ($request->user()->hasRole('admin') || Auth::id() === $menu->user->id){
            return $next($request);
        }else{
            abort(Response::HTTP_UNAUTHORIZED,'Unauthorized');
        }
    }
}
