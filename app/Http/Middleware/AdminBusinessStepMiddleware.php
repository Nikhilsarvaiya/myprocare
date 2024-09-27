<?php

namespace App\Http\Middleware;

use App\Models\Business;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminBusinessStepMiddleware
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
            if (request()->routeIs('admin.businesses.basic_details.edit') ||
                request()->routeIs('admin.businesses.opening_hours.edit')) {
                return $next($request);
            } else {
                return redirect()->route('admin.businesses.opening_hours.edit', $business->id);
            }
        }

        if ($business->step_completed < 3) {
            if (request()->routeIs('admin.businesses.basic_details.edit') ||
                request()->routeIs('admin.businesses.opening_hours.edit') ||
                request()->routeIs('admin.businesses.links.edit')) {
                return $next($request);
            } else {
                return redirect()->route('admin.businesses.links.edit', $business->id);
            }
        }

        if ($business->step_completed < 4) {
            if (request()->routeIs('admin.businesses.basic_details.edit') ||
                request()->routeIs('admin.businesses.opening_hours.edit') ||
                request()->routeIs('admin.businesses.links.edit') ||
                request()->routeIs('admin.businesses.media.edit')) {
                return $next($request);
            } else {
                return redirect()->route('admin.businesses.media.edit', $business->id);
            }
        }

        if ($business->step_completed < 5 && $business->businessType->sell_food_beverage) {
            if (request()->routeIs('admin.businesses.basic_details.edit') ||
                request()->routeIs('admin.businesses.opening_hours.edit') ||
                request()->routeIs('admin.businesses.links.edit') ||
                request()->routeIs('admin.businesses.media.edit') ||
                request()->routeIs('admin.businesses.restaurant_type.edit')) {
                return $next($request);
            } else {
                return redirect()->route('admin.businesses.restaurant_type.edit', $business->id);
            }
        }

        if ($business->step_completed < 6 && $business->businessType->sell_food_beverage) {
            if (request()->routeIs('admin.businesses.basic_details.edit') ||
                request()->routeIs('admin.businesses.opening_hours.edit') ||
                request()->routeIs('admin.businesses.links.edit') ||
                request()->routeIs('admin.businesses.media.edit') ||
                request()->routeIs('admin.businesses.restaurant_type.edit') ||
                request()->routeIs('admin.businesses.menus.edit.index')
            ) {
                return $next($request);
            } else {
                return redirect()->route('admin.businesses.menus.edit.index', $business->id);
            }
        }

        if ($business->step_completed < 5 && !$business->businessType->sell_food_beverage) {
            if (request()->routeIs('admin.businesses.basic_details.edit') ||
                request()->routeIs('admin.businesses.opening_hours.edit') ||
                request()->routeIs('admin.businesses.links.edit') ||
                request()->routeIs('admin.businesses.media.edit') ||
                request()->routeIs('admin.businesses.products.edit.index')) {
                return $next($request);
            } else {
                return redirect()->route('admin.businesses.products.edit.index', $business->id);
            }
        }

        return $next($request);
    }
}
