<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\Centers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class KearnyNorthsActiveStudentsController extends Controller
{
    public function index(Request $request)
    {
        // Active Students
        $active_students = Students::query()
            ->select(
                \DB::raw('DATE(created_at) as created_at_date'),
                \DB::raw('COUNT(CASE WHEN enrollment_status = "Full-Time" THEN 1 END) as full_time'),
                \DB::raw('COUNT(CASE WHEN enrollment_status = "Part-Time" THEN 1 END) as part_time'),
                \DB::raw('(
                    COUNT(CASE WHEN enrollment_status = "Full-Time" THEN 1 END) + 
                    COUNT(CASE WHEN enrollment_status = "Part-Time" THEN 1 END)
                ) as total'),
            )
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'active')
            ->groupBy('created_at_date')
            ->orderby('created_at_date', 'desc')
            ->paginate(10);


        return view('admin.active-students.active-students-index', compact('active_students'));
    }
}