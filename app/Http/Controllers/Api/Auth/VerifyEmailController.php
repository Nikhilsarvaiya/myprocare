<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'otp' => ['required', 'numeric'],
        ]);

        if ($validator->fails()){
            return \response()->json([
                'message' => 'Validation error.',
                'errors' => $validator->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'User already verified email.',
                'errors' => [
                    'email' => 'email is already verified.',
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $authUser = $request->user();

        // Check OTP is valid
        if ($request->otp == $authUser->otp->otp){
            if ($authUser->markEmailAsVerified()) {
                $authUser->currentAccessToken()->delete();

                $authUser->assignRole('user');
                $token = $authUser->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'message' => 'Email verified successfully.',
                    'user' => new UserResource($authUser),
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ], 200);
            }else{
                return response()->json([
                    'message' => 'Something went wrong. Email not verified.',
                ], Response::HTTP_BAD_REQUEST);
            }
        }else{
            return response()->json([
                'message' => 'Incorrect otp.',
                'errors' => [
                    'otp' => 'Incorrect otp. please check otp.',
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
