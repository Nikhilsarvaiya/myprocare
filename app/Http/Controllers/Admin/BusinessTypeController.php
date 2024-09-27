<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessTypeRequest;
use App\Http\Requests\UpdateBusinessTypeRequest;
use App\Models\BusinessType;
use Illuminate\Http\Request;

class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $businessTypes = BusinessType::query()
            ->with('media')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")->OrWhere('description', 'like', "%$request->search%");
                });
            })
            ->orderBy($request->orderKey ?? 'id', $request->orderDirection ?? 'desc')
            ->paginate(10);

        $businessTypes->withQueryString();

        return view('admin.business-types.business-types-index', compact('businessTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.business-types.business-types-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusinessTypeRequest $request)
    {
        $businessType = BusinessType::create($request->validated());

        $businessType->addMedia($request->image)->toMediaCollection();

        return redirect()->route('admin.business-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessType $businessType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessType $businessType)
    {
        return view('admin.business-types.business-types-edit', compact('businessType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessTypeRequest $request, BusinessType $businessType)
    {
        $businessType->update($request->validated());

        if ($request->image){
            foreach ($businessType->media as $media){
                $media->delete();
            }

            $businessType->addMedia($request->image)->toMediaCollection();
        }

        return redirect()->route('admin.business-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessType $businessType)
    {
        $businessType->delete();

        return redirect()->route('admin.business-types.index');
    }
}
