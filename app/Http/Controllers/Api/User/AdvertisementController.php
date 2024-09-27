<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Models\Advertisement;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $advertisementsQuery = Advertisement::query();

        if (isset($request->include)) {
            $relationships = explode(',', $request->include);
            $diff = array_diff($relationships, Advertisement::VALID_RELATIONS);

            if (count($diff) > 0) {
                return response()->json([
                    'message' => 'the include field is invalid: ' . implode(',', $diff),
                ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
            }

            $advertisementsQuery->with($relationships);
        }

        $advertisements = $advertisementsQuery->paginate(10);

        $advertisements->withQueryString();

        return AdvertisementResource::collection($advertisements);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Advertisement $advertisement)
    {
        $advertisementQuery = Advertisement::query();

        if (isset($request->include)) {
            $relationships = explode(',', $request->include);
            $diff = array_diff($relationships, Advertisement::VALID_RELATIONS);

            if (count($diff) > 0) {
                return response()->json([
                    'message' => 'the include field is invalid: ' . implode(',', $diff),
                ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
            }

            $advertisementQuery->with($relationships);
        }

        $advertisement = $advertisementQuery->find($advertisement->id);

        return new AdvertisementResource($advertisement);
    }
}
