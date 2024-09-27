<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoadClosureRequest;
use App\Http\Requests\UpdateRoadClosureRequest;
use App\Http\Resources\RoadClosureResource;
use App\Models\RoadClosure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RoadClosureController extends Controller
{
    public function all(){
        $roadClosures = RoadClosure::query()
            ->where('end_time', '>=', Carbon::now())
            ->paginate(10);

        $roadClosures->withQueryString();

        return RoadClosureResource::collection($roadClosures);
    }

    public function index()
    {
        $roadClosures = RoadClosure::query()
            ->where([
                ['user_id', \Auth::id()],
                ['end_time', '>=', Carbon::now()]
            ])
            ->paginate(10);

        $roadClosures->withQueryString();

        return RoadClosureResource::collection($roadClosures);
    }

    public function store(StoreRoadClosureRequest $request)
    {
        $roadClosure = RoadClosure::query()->create($request->validated());

        return new RoadClosureResource($roadClosure);
    }

    public function show(RoadClosure $roadClosure)
    {
        return new RoadClosureResource($roadClosure);
    }

    public function update(UpdateRoadClosureRequest $request, RoadClosure $roadClosure)
    {
        // array filter for remove null values from validated
        $roadClosure->update(array_filter($request->validated()));

        return new RoadClosureResource($roadClosure);
    }

    public function destroy(RoadClosure $roadClosure)
    {
        if ($roadClosure->user_id !== Auth::id()){
            return response()->json(['message' => 'Unauthenticated.'], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $roadClosure->delete();

        return response()->noContent(ResponseAlias::HTTP_OK);
    }
}
