<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $userQuery = User::query();

        if (isset($request->include)) {
            $relationships = explode(',', $request->include);
            $diff = array_diff($relationships, User::VALID_RELATIONS);

            if (count($diff) > 0) {
                return response()->json([
                    'message' => 'the include field is invalid: ' . implode(',', $diff),
                ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
            }

            $userQuery->with($relationships);
        }

        $user = $userQuery->where('id', Auth::id())->first();

        return new ProfileResource($user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['string', 'max:255'],
            'profile' => ['image', 'mimes:jpeg,jpg,png', 'max:2048']
        ]);

        $request->user()->update([
            'name' => $request->name,
        ]);

        $request->user()->clearMediaCollection('profile');

        $request->user()->addMediaFromRequest('profile')->toMediaCollection('profile');

        return response()->noContent();
    }

    public function myQr()
    {
         return QrCode::size(200)->generate(Auth::id());
    }
}
