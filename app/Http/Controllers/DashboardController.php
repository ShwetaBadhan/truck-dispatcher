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
        $batchId = $student?->batch_id;

         $allLectures = $batchId
        ? DailyLecture::with(['batch', 'syllabus', 'teacher'])
            ->where('batch_id', $batchId)
            ->get()
        : collect();

        $stats = [
            'topics'     => $allLectures->pluck('syllabus_id')->unique()->count(),
            'lectures'   => $allLectures->count(),
            'assignments'=> $allLectures->where('pdf_path', '!=', null)->count(),
            'upcoming'   => $allLectures->where('lecture_date', '>=', now()->startOfDay())->count(),
        ];

        // Last 7 days activity (line chart)
        $activity = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = $allLectures->where('lecture_date', $date)->count();
            $activity[] = ['date' => now()->subDays($i)->format('D'), 'count' => $count];
        }

        // Syllabus progress (donut)
        $totalSyllabus = Syllabus::where('status', 1)->count();
        $coveredTopics = $allLectures->pluck('syllabus_id')->unique()->count();
        $progress = $totalSyllabus > 0 ? round(($coveredTopics / $totalSyllabus) * 100) : 0;

        // Top syllabus topics covered (top sale jaisa)
        $topTopics = $allLectures->groupBy('syllabus_id')
            ->map->count()
            ->sortDesc()
            ->take(6);

        $syllabusDetails = Syllabus::whereIn('id', $topTopics->keys())->get()->keyBy('id');

        $recentLectures = DailyLecture::with(['syllabus', 'teacher'])
            ->where('batch_id', $batchId)
            ->latest('lecture_date')->latest('id')
            ->take(5)
            ->get();

        // Upcoming lectures (user location ki jagah)
        $upcomingLectures = DailyLecture::with(['syllabus', 'teacher'])
            ->where('batch_id', $batchId)
            ->where('lecture_date', '>=', now()->startOfDay())
            ->oldest('lecture_date')
            ->take(6)
            ->get();

        return view('pages.student-dashboard', compact(
            'student', 'stats', 'activity', 'progress', 'totalSyllabus', 'coveredTopics',
            'topTopics', 'syllabusDetails', 'recentLectures', 'upcomingLectures'
        ));
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