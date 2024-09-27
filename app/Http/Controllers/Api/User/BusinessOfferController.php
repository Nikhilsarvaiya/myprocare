<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessOfferRequest;
use App\Http\Requests\UpdateBusinessOfferRequest;
use App\Http\Resources\BusinessOfferResource;
use App\Models\Business;
use App\Models\BusinessOffer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BusinessOfferController extends Controller
{
    /**
     * Display all listing of the resource.
     */
    public function all(){
        $business_offers = BusinessOffer::query()->with(['media','business'])->paginate(10);

        $business_offers->withQueryString();

        return BusinessOfferResource::collection($business_offers);
    }

    /**
     * Display user's listing of the resource.
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

        return BusinessOfferResource::collection($business_offers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBusinessOfferRequest $request)
    {
        $business_offer = BusinessOffer::create($request->validated());

        $business_offer->addMedia($request->image)->toMediaCollection();

        return response()->noContent(ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessOffer $business_offer)
    {
        $business_offer = BusinessOffer::query()->with(['media', 'business'])->where('id', $business_offer->id)->first();

        return new BusinessOfferResource($business_offer);
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

        return response()->noContent(ResponseAlias::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessOffer $business_offer)
    {
        if ($business_offer->user->id !== Auth::id()){
            return response()->json(['message' => 'Unauthenticated.'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $business_offer->clearMediaCollection();
        $business_offer->delete();

        return response()->noContent(ResponseAlias::HTTP_OK);
    }
}
