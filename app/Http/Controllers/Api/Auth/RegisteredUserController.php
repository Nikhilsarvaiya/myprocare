<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Auth\RegisteredOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        /**
         * comment for sometime verified user due to mail server
         */
//        // delete user if not verified email
//        $get_user = User::query()
//            ->where([
//                ['email', $request->email],
//                ['email_verified_at', null],
//            ])->first();
//        if ($get_user) {
//            $get_user->delete();
//        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($validator->fails()) {
            return \response()->json([
                'message' => 'Failed to register user.',
                'errors' => $validator->messages()
            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('user');

        /**
         * comment for sometime verified user due to mail server
         */
//        // send otp to user
//        $otp = rand(111111, 999999);
//        $user->otp()->create([
//            'otp' => $otp
//        ]);
//
//        try {
//            $user->notify(new RegisteredOtp($otp));
//        }catch (\Exception $e){
//            return response()->json([
//                'message' => 'Otp Does Not Send! Please try again.',
//            ], 400);
//        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], ResponseAlias::HTTP_CREATED);
    }
}
