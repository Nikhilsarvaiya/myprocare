<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCentersRequest;
use App\Http\Requests\UpdateCentersRequest;
use App\Models\Centers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CentersController extends Controller
{
    public function index(Request $request)
    {
        $centers = Centers::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")->orWhere('capacity', 'like', "%$request->search%")->orWhere('goal', 'like', "%$request->search%");
                });
            })
            ->orderBy(request('orderKey') ?? 'id', request('orderDirection') ?? 'desc')
            ->paginate(10);

        $centers->withQueryString();
        return view('admin.centers.centers-index', compact('centers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.centers.centers-create');
    }

    public function store(StoreCentersRequest $request)
    {
        $center = Centers::create($request->validated());
        return redirect()->route('admin.centers.index');
    }

    public function edit($id)
    {
        $center = Centers::query()->where('id', $id)->first();
        return view('admin.centers.centers-edit', compact('center'));
    }

    public function update(UpdateCentersRequest $request, Centers $centers)
    {
        // array filter for remove null values from validated
        // $centers->update(array_filter($request->validated()));

        $centers = Centers::find($request->id);
        $centers->name = $request->name;
        $centers->capacity = $request->capacity;
        $centers->goal = $request->goal;
        $centers->save();
        return redirect()->route('admin.centers.index');
    }

    public function destroy(UpdateCentersRequest $request, Centers $centers)
    {
        Centers::where('id', $request->id)->delete();
        // $centers->delete();
        return redirect()->route('admin.centers.index');
    }
}
