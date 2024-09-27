<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantTypeRequest;
use App\Http\Requests\UpdateRestaurantTypeRequest;
use App\Models\RestaurantType;
use Illuminate\Http\Request;

class RestaurantTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $restaurantTypes = RestaurantType::query()
            ->with('media')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")->OrWhere('description', 'like', "%$request->search%");
                });
            })
            ->orderBy($request->orderKey ?? 'id', $request->orderDirection ?? 'desc')
            ->paginate(10);

        $restaurantTypes->withQueryString();

        return view('admin.restaurant-types.restaurant-types-index', compact('restaurantTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.restaurant-types.restaurant-types-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantTypeRequest $request)
    {
        $restaurantType = RestaurantType::create($request->validated());

        $restaurantType->addMedia($request->image)->toMediaCollection();

        return redirect()->route('admin.restaurant-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RestaurantType $restaurantType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestaurantType $restaurantType)
    {
        return view('admin.restaurant-types.restaurant-types-edit', compact('restaurantType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantTypeRequest $request, RestaurantType $restaurantType)
    {
        $restaurantType->update($request->validated());

        if ($request->image){
            foreach ($restaurantType->media as $media){
                $media->delete();
            }

            $restaurantType->addMedia($request->image)->toMediaCollection();
        }

        return redirect()->route('admin.restaurant-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RestaurantType $restaurantType)
    {
        $restaurantType->delete();

        return redirect()->route('admin.restaurant-types.index');
    }
}
