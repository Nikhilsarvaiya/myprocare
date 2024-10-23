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

class InActiveReportController extends Controller
{
    public function index(Request $request)
    {
        $grand_total = 0;

        $preschool = Students::query()
            ->where('room', 'like', "%Preschool%")
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'inactive')
            ->count();

        $preschool_flex = Students::query()
            ->where('room', 'like', "%Preschool Flex%")
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'inactive')
            ->count();

        $school_age = Students::query()
            ->where('room', 'like', "%School Age%")
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'inactive')
            ->count();

        $toddlers = Students::query()
            ->where('room', 'like', "%Toddlers%")
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'inactive')
            ->count();

        $grand_total = $preschool + $preschool_flex + $school_age + $toddlers;

        $enrollment_status_null = Students::query()
            ->where('enrollment_status', 'like', "%-%")
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'inactive')
            ->count();

        $enrollment_status_full_time = Students::query()
            ->where('enrollment_status', 'like', "%Full-Time%")
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'inactive')
            ->count();

        $enrollment_status_part_time = Students::query()
            ->where('enrollment_status', 'like', "%Part-Time%")
            ->where('nj_area', 'like', "%Kearny North%")
            ->where('type', 'inactive')
            ->count();

        $enrollment_status_grand_total = $enrollment_status_null + $enrollment_status_full_time + $enrollment_status_part_time;

        $data = [
            'preschool' => $preschool,
            'preschool_flex' => $preschool_flex,
            'school_age' => $school_age,
            'toddlers' => $toddlers,
            'grand_total' => $grand_total,
            'enrollment_status_null' => $enrollment_status_null,
            'enrollment_status_full_time' => $enrollment_status_full_time,
            'enrollment_status_part_time' => $enrollment_status_part_time,
            'enrollment_status_grand_total' => $enrollment_status_grand_total,
        ];

        return view('admin.inactive-report.inactive-report-index', compact('data'));
    }
}
