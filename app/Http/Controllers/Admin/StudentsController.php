<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Students;
use App\Models\Centers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = Students::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('fname', 'like', "%$request->search%")->OrWhere('lname', 'like', "%$request->search%")->OrWhere('room', 'like', "%$request->search%")->OrWhere('enrollment_status', 'like', "%$request->search%")->OrWhere('type', 'like', "%$request->search%")->OrWhere('address', 'like', "%$request->search%")->OrWhere('city', 'like', "%$request->search%")->OrWhere('country_code', 'like', "%$request->search%")->OrWhere('zip', 'like', "%$request->search%")->OrWhere('adminssion_date', 'like', "%$request->search%")->OrWhere('graduation_date', 'like', "%$request->search%");
                });
            })
            ->when($request->centers, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('nj_area', 'like', "%$request->centers%");
                });
            })
            ->orderBy(request('orderKey') ?? 'id', request('orderDirection') ?? 'desc')
            ->paginate(10);

        $students->withQueryString();

        // Centers
        $centers = Centers::get();

        isset(request()->centers) ? $allcenters = request()->centers : $allcenters = '';

        return view('admin.students.students-index', compact('students', 'centers', 'allcenters'));
    }
}
