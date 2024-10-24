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

class KearnyNorthsController extends Controller
{
    public function index(Request $request)
    {
        $retention_rate = 0;
        $center_capacity = 0;
        $percent_capacity = 0;
        $goal = 0;
        $total_score = 0;

        $active_student = Students::query()
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'active')
            ->count();

        $inactive_student = Students::query()
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'inactive')
            ->count();

        $total_student = $active_student + $inactive_student;

        $retention_rate = $active_student / $total_student;

        $centers = Centers::query()->where('name', 'Kearny North')->first();

        if(!empty($centers)){
            $center_capacity = $centers->capacity;
            $goal = $centers->goal;
        }

        $percent_capacity = $active_student / $center_capacity;

        $total_score = ($percent_capacity >= $goal) ? 100 : (($percent_capacity / $goal) * 100);

        $data = [
            'active_student' => $active_student,
            'inactive_student' => $inactive_student,
            'total_student' => $total_student,
            'retention_rate' => $retention_rate,
            'center_capacity' => $center_capacity,
            'percent_capacity' => $percent_capacity,
            'goal' => $goal,
            'total_score' => $total_score,
        ];

        return view('admin.kearny-norths.kearny-norths-index', compact('data'));
    }
}
