<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%$request->search%")->OrWhere('email', 'like', "%$request->search%");
                });
            })
            ->orderBy(request('orderKey') ?? 'id', request('orderDirection') ?? 'desc')
            ->paginate(10);

        $users->withQueryString();

        return view('admin.users.users-index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = collect(RoleEnum::cases())->map(function($role){
            return (object)[
                'value' => $role->value,
                'label' => $role->value,
            ];
        });

        return view('admin.users.users-create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        $user->assignRole($request->roles);

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::query()->with('roles')->where('id', $id)->first();

        $roles = collect(RoleEnum::cases())->map(function($role) use($user){
            return (object)[
                'value' => $role->value,
                'label' => $role->value,
                'selected' => $user->roles->contains(function ($item) use($role) {
                    return $item->name == $role->value;
                })
            ];
        });

        return view('admin.users.users-edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // array filter for remove null values from validated
        $user->update(array_filter($request->validated()));

        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
