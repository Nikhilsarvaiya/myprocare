<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Auth\ForgotPasswordOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ForgotPasswordController extends Controller
{
    public function store(Request $request){
        $user = User::where('email', $request->email)->first();
        if (!$user){
            return response()->json([
                'message' => 'Your account does not registered with us. Please register your account.'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        $otp = rand(100000, 999999);
        $user->otp()->updateOrCreate([],[
            'otp' => $otp
        ]);

        try {
            $user->notify(new ForgotPasswordOtp($otp));
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Otp Does Not Send! Please try again.',
            ], ResponseAlias::HTTP_BAD_REQUEST);
        }

        return response()->noContent();
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => ['required', Password::defaults(), 'confirmed'],
            'otp' => ['required', 'numeric'],
        ]);

        if ($validator->fails()){
            return \response()->json([
                'message' => 'Validation error.',
                'errors' => $validator->messages()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::query()
            ->where('email', $request->email)->first();

        // Check OTP is valid
        if ($request->otp === $user->otp->otp){
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            $user->otp()->delete();
        }else{
            return response()->json([
                'message' => 'Incorrect otp.',
                'errors' => [
                    'otp' => 'Incorrect otp. please check otp.',
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }
}
