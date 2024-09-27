<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Http\Resources\DealResource;
use App\Models\Deal;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DealController extends Controller
{
    public function all(){
        $deals = Deal::query()->with('media')->paginate(10);

        $deals->withQueryString();

        return DealResource::collection($deals);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deals = Deal::query()
            ->with('media')
            ->where('user_id', Auth::id())
            ->paginate(10);

        $deals->withQueryString();

        return DealResource::collection($deals);
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreDealRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $deal = Deal::create($data);

        $deal->addMedia($request->image)->toMediaCollection();

        return response()->noContent(ResponseAlias::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($dealId)
    {
        $deal = Deal::query()->with('media')->where('id', $dealId)->first();

        return new DealResource($deal);
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

        return response()->noContent(ResponseAlias::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        if ($deal->user_id !== Auth::id()){
            return response()->json(['message' => 'Unauthenticated.'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $deal->clearMediaCollection();
        $deal->delete();

        return response()->noContent(ResponseAlias::HTTP_OK);
    }
}
