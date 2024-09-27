<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $wallet = \Auth::user()->getWallet();

        return new WalletResource($wallet);
    }
}
