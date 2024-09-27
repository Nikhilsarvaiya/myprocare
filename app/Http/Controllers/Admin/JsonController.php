<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    public function userEmailList(Request $request){
        $users = \App\Models\User::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")->OrWhere('email', 'like', "%$request->search%");
                });
            })
            ->limit(10)
            ->pluck('email');

        return response()->json($users);
    }

    public function usersEmail(Request $request){
        $users = \App\Models\User::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('email', 'like', "%$request->search%");
            })
            ->limit(10)
            ->pluck('email');

        return response()->json($users);
    }

    public function businessesName(Request $request){
        $businesses = \App\Models\Business::query()
            ->select(['id','name'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', "%$request->search%");
            })
            ->limit(10)
            ->toBase()
            ->get();

        return response()->json($businesses);
    }
}
