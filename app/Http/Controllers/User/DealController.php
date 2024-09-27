<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $deals = Deal::query()
            ->with('media')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")->OrWhere('description', 'like', "%$request->search%");
                });
            })
            ->where('user_id', Auth::id())
            ->orderBy($request->orderKey ?? 'id', $request->orderDirection ?? 'desc')
            ->paginate(10);

        $deals->withQueryString();

        return view('user.deals.deals-index', compact('deals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.deals.deals-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDealRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $deal = Deal::create($data);

        $deal->addMedia($request->image)
            ->toMediaCollection();

        return redirect()->route('user.deals.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deal $deal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deal $deal)
    {
        return view('user.deals.deals-edit', compact('deal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDealRequest $request, Deal $deal)
    {
        $deal->update($request->validated());

        if ($request->file('image')){
            $deal->clearMediaCollection();

            $deal->addMedia($request->image)->toMediaCollection();
        }

        return redirect()->route('user.deals.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        if ($deal->user_id !== Auth::id()){
            abort(ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $deal->clearMediaCollection();
        $deal->delete();

        return redirect()->route('user.deals.index');
    }
}
