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

class KearnyNorthsStudentsPerRoomsController extends Controller
{
    public function index(Request $request)
    {
        // Students per room
        $students_per_rooms = Students::query()
            ->select(
                \DB::raw('DATE(created_at) as created_at_date'),
                \DB::raw('COUNT(CASE WHEN room = "School Age" THEN 1 END) as school_age'),
                \DB::raw('COUNT(CASE WHEN room = "Preschool" THEN 1 END) as preschool_age'),
                \DB::raw('COUNT(CASE WHEN room = "Pre Flex" THEN 1 END) as pre_flex_age'),
                \DB::raw('COUNT(CASE WHEN room = "Toddler\'s Room B" THEN 1 END) as toddler_room_b_age'),
                \DB::raw('COUNT(CASE WHEN room = "School Age B" THEN 1 END) as school_age_b_age'),
                \DB::raw('COUNT(CASE WHEN room = "Summer Camp" THEN 1 END) as summer_camp_age'),
                \DB::raw('(
                    COUNT(CASE WHEN room = "School Age" THEN 1 END) + 
                    COUNT(CASE WHEN room = "Summer Camp" THEN 1 END)
                ) as total_students'),
            )
            ->where('nj_area', 'like', "%Kearny North%")
            ->groupBy('created_at_date')
            ->orderby('created_at_date', 'desc')
            ->paginate(10);

        return view('admin.students-per-rooms.students-per-rooms-index', compact('students_per_rooms'));
    }
}
