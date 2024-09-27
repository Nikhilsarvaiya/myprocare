<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $advertisements = Advertisement::query()
            ->with('media')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', "%$request->search%")->OrWhere('link', 'like', "%$request->search%");
                });
            })
            ->orderBy($request->orderKey ?? 'id', $request->orderDirection ?? 'desc')
            ->paginate(10);

        $advertisements->withQueryString();

        return view('admin.advertisements.advertisements-index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.advertisements.advertisements-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdvertisementRequest $request)
    {
        $advertisement = Advertisement::create($request->validated());

        $advertisement->addMedia($request->image)->toMediaCollection();

        return redirect()->route('admin.advertisements.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        $advertisement = Advertisement::query()->with('business')->find($advertisement->id);

        return view('admin.advertisements.advertisements-edit', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdvertisementRequest $request, Advertisement $advertisement)
    {
        $advertisement->update($request->validated());

        if ($request->file('image')){
            $advertisement->clearMediaCollection();

            $advertisement->addMedia($request->image)->toMediaCollection();
        }

        return redirect()->route('admin.advertisements.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        $advertisement->clearMediaCollection();
        $advertisement->delete();

        return redirect()->route('admin.advertisements.index');
    }
}
