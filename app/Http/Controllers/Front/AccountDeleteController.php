<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAccountDeleteRequest;
use App\Models\AccountDelete;

class AccountDeleteController extends Controller
{
    public function index()
    {
        return view('front.account-delete-request');
    }

    public function store(StoreAccountDeleteRequest $request){
        AccountDelete::create($request->validated());

        return redirect()->route('account_delete.index')->with(['status' => 'request-send']);
    }
}
