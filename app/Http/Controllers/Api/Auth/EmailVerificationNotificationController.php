<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\Auth\RegisteredOtp;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'User already verified email.',
                'errors' => [
                    'email' => 'email is already verified.',
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $otp = rand(111111, 999999);
        $user->otp()->updateOrCreate([],[
            'otp' => $otp
        ]);

        $user->notify(new RegisteredOtp($otp));

        return response()->noContent(ResponseAlias::HTTP_NO_CONTENT);
    }
}
