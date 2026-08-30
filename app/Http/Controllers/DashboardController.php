<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\DailyLecture;
use App\Models\Dispatch;
use App\Models\Student;
use App\Models\Syllabus;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

   
    $isStudent = $user->hasRole('student') || $user->student()->exists();

    if ($isStudent) {
        return $this->studentDashboard($user);
    }

    return $this->adminDashboard();
}

    // ============ STUDENT DASHBOARD ============
   private function studentDashboard($user)
{
    $student = $user->student;

    if ($student) {
        $student->load(['batch']);
    }

    // Batch ki total lectures
    $lectureCount = ($student && $student->batch_id)
        ? DailyLecture::where('batch_id', $student->batch_id)->count()
        : 0;

   
    $holidays = collect(range(0, 4))->map(fn ($i) => now()->modify('next sunday')->addWeeks($i));

    return view('pages.student-dashboard', compact('student', 'lectureCount', 'holidays'));
}

    // ============ ADMIN DASHBOARD ============
    private function adminDashboard()
    {
        $stats = [
            'students'   => Student::count(),
            'batches'    => Batch::where('status', 1)->count(),
            'lectures'   => DailyLecture::count(),
            'syllabuses' => Syllabus::where('status', 1)->count(),
            'dispatches' => Dispatch::count(),
            'trucks'     => Truck::count(),
        ];

        // Last 7 days lecture activity
        $lectureActivity = [];
        $studentActivity = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $lectureActivity[] = [
                'date' => now()->subDays($i)->format('D'),
                'count' => DailyLecture::whereDate('lecture_date', $date)->count(),
            ];
            $studentActivity[] = [
                'date' => now()->subDays($i)->format('D'),
                'count' => Student::whereDate('created_at', $date)->count(),
            ];
        }

        // Batch wise student distribution (donut)
        $batchDistribution = Batch::withCount('students')
            ->where('status', 1)
            ->orderByDesc('students_count')
            ->take(4)
            ->get();

        // Top batches by lecture count
        $topBatches = Batch::withCount(['dailyLectures', 'students'])
            ->orderByDesc('daily_lectures_count')
            ->take(6)
            ->get();

        $recentLectures = DailyLecture::with(['batch', 'syllabus', 'teacher'])
            ->latest('lecture_date')->latest('id')
            ->take(5)
            ->get();

        $recentStudents = Student::with('batch')
            ->latest()
            ->take(6)
            ->get();

        return view('pages.admin-dashboard', compact(
            'stats', 'lectureActivity', 'studentActivity', 'batchDistribution',
            'topBatches', 'recentLectures', 'recentStudents'
        ));
    }
}