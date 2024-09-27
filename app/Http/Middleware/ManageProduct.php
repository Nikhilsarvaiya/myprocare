<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManageProduct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->product instanceof Product) {
            $product = $request->product;
        } else {
            $product = Product::query()->where('id', '=', $request->route()->parameter('product'))->firstOrFail();
        }

        if ($request->user()->hasRole('admin') || Auth::id() === $product->user->id){
            return $next($request);
        }else{
            abort(Response::HTTP_UNAUTHORIZED,'Unauthorized');
        }
    }
}
