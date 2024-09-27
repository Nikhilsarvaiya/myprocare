<?php

namespace App\Http\Middleware;

use App\Models\Business;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserBusinessStepMiddleware
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

        if ($business->step_completed < 2) {
            if (request()->routeIs('user.businesses.basic_details.edit') ||
                request()->routeIs('user.businesses.opening_hours.edit')) {
                return $next($request);
            } else {
                return redirect()->route('user.businesses.opening_hours.edit', $business->id);
            }
        }

        if ($business->step_completed < 3) {
            if (request()->routeIs('user.businesses.basic_details.edit') ||
                request()->routeIs('user.businesses.opening_hours.edit') ||
                request()->routeIs('user.businesses.links.edit')) {
                return $next($request);
            } else {
                return redirect()->route('user.businesses.links.edit', $business->id);
            }
        }

        if ($business->step_completed < 4) {
            if (request()->routeIs('user.businesses.basic_details.edit') ||
                request()->routeIs('user.businesses.opening_hours.edit') ||
                request()->routeIs('user.businesses.links.edit') ||
                request()->routeIs('user.businesses.media.edit')) {
                return $next($request);
            } else {
                return redirect()->route('user.businesses.media.edit', $business->id);
            }
        }

        if ($business->step_completed < 5 && $business->businessType->sell_food_beverage) {
            if (request()->routeIs('user.businesses.basic_details.edit') ||
                request()->routeIs('user.businesses.opening_hours.edit') ||
                request()->routeIs('user.businesses.links.edit') ||
                request()->routeIs('user.businesses.media.edit') ||
                request()->routeIs('user.businesses.restaurant_type.edit')) {
                return $next($request);
            } else {
                return redirect()->route('user.businesses.restaurant_type.edit', $business->id);
            }
        }

        if ($business->step_completed < 6 && $business->businessType->sell_food_beverage) {
            if (request()->routeIs('user.businesses.basic_details.edit') ||
                request()->routeIs('user.businesses.opening_hours.edit') ||
                request()->routeIs('user.businesses.links.edit') ||
                request()->routeIs('user.businesses.media.edit') ||
                request()->routeIs('user.businesses.restaurant_type.edit') ||
                request()->routeIs('user.businesses.menus.edit.index')
            ) {
                return $next($request);
            } else {
                return redirect()->route('user.businesses.menus.edit.index', $business->id);
            }
        }

        if ($business->step_completed < 5 && !$business->businessType->sell_food_beverage) {
            if (request()->routeIs('user.businesses.basic_details.edit') ||
                request()->routeIs('user.businesses.opening_hours.edit') ||
                request()->routeIs('user.businesses.links.edit') ||
                request()->routeIs('user.businesses.media.edit') ||
                request()->routeIs('user.businesses.products.edit.index')) {
                return $next($request);
            } else {
                return redirect()->route('user.businesses.products.edit.index', $business->id);
            }
        }

        return $next($request);
    }
}
