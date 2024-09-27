<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodTypeRequest;
use App\Http\Requests\UpdateFoodTypeRequest;
use App\Models\FoodType;
use Illuminate\Http\Request;

class FoodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $foodTypes = FoodType::query()
            ->with('media')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")->OrWhere('description', 'like', "%$request->search%");
                });
            })
            ->orderBy($request->orderKey ?? 'id', $request->orderDirection ?? 'desc')
            ->paginate(10);

        $foodTypes->withQueryString();

        return view('admin.food-types.food-types-index', compact('foodTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.food-types.food-types-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodTypeRequest $request)
    {
        $foodType = FoodType::create($request->validated());

        $foodType->addMedia($request->image)->toMediaCollection();

        return redirect()->route('admin.food-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FoodType $foodType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodType $foodType)
    {
        return view('admin.food-types.food-types-edit', compact('foodType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodTypeRequest $request, FoodType $foodType)
    {
        $foodType->update($request->validated());

        if ($request->image){
            foreach ($foodType->media as $media){
                $media->delete();
            }

            $foodType->addMedia($request->image)->toMediaCollection();
        }

        return redirect()->route('admin.food-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodType $foodType)
    {
        $foodType->delete();

        return redirect()->route('admin.food-types.index');
    }
}
