<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoadClosureRequest;
use App\Http\Requests\UpdateRoadClosureRequest;
use App\Http\Resources\RoadClosureResource;
use App\Models\RoadClosure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RoadClosureController extends Controller
{
    public function index(Request $request)
    {
        $road_closures = RoadClosure::query()
            ->with(['user'])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('title', 'like', "%$request->search%");
                });
            })
            ->where('end_time', '>=', Carbon::now())
            ->orderBy($request->orderKey ?? 'id', $request->orderDirection ?? 'desc')
            ->paginate(10);

        $road_closures->withQueryString();

        return view('admin.road-closures.road-closures-index', compact('road_closures'));
    }

    public function create()
    {
        return view('admin.road-closures.road-closures-create');
    }

    public function store(StoreRoadClosureRequest $request)
    {
        RoadClosure::create($request->validated());

        return redirect()->route('admin.road-closures.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(RoadClosure $road_closure)
    {
        //
    }

    public function edit(RoadClosure $road_closure)
    {
        return view('admin.road-closures.road-closures-edit', compact('road_closure'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoadClosureRequest $request, RoadClosure $road_closure)
    {
        // array filter for remove null values from validated
        $road_closure->update(array_filter($request->validated()));

        return redirect()->route('admin.road-closures.index');
    }

    public function destroy(RoadClosure $road_closure)
    {
        $road_closure->delete();

        return redirect()->route('admin.road-closures.index');
    }
}
