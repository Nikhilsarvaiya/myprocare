<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessOfferRequest;
use App\Http\Requests\UpdateBusinessOfferRequest;
use App\Models\Business;
use App\Models\BusinessOffer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BusinessOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $business_offers = BusinessOffer::query()
            ->with(['media', 'business'])
            ->whereHas('user', function (Builder $query) {
                $query->where('user_id', \Auth::id());
            })
            ->when($request->search, function (Builder $query) {
                $query->where(function ($query) {
                    $query->where('title', 'like', "%" . request('search') . "%")
                        ->OrWhere('description', 'like', "%" . request('search') . "%");
                });
            })
            ->orderBy($request->orderKey ?? 'id', $request->orderDirection ?? 'desc')
            ->paginate(10);

        $business_offers->withQueryString();

        return view('user.business-offers.business-offers-index', compact('business_offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $businesses = Business::query()->where('user_id', \Auth::id())->get();

        return view('user.business-offers.business-offers-create', compact('businesses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusinessOfferRequest $request)
    {
        $business_offer = BusinessOffer::create($request->validated());

        $business_offer->addMedia($request->image)->toMediaCollection();

        return redirect()->route('user.business-offers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessOffer $business_offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessOffer $business_offer)
    {
        $businesses = Business::query()->where('user_id', \Auth::id())->get();

        return view('user.business-offers.business-offers-edit', compact('business_offer', 'businesses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBusinessOfferRequest $request, BusinessOffer $business_offer)
    {
        $business_offer->update($request->validated());

        if ($request->file('image')) {
            $business_offer->clearMediaCollection();

            $business_offer->addMedia($request->image)->toMediaCollection();
        }

        return redirect()->route('user.business-offers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessOffer $business_offer)
    {
        if ($business_offer->user->id !== Auth::id()){
            abort(ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $business_offer->clearMediaCollection();
        $business_offer->delete();

        return redirect()->route('user.business-offers.index');
    }
}
