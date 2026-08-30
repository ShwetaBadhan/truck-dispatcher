<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\DailyLecture;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DailyLectureController extends Controller
{
public function index()
{
    $user = auth()->user();
    $student = $user->student;   

    $query = DailyLecture::query()->with(['batch', 'syllabus', 'teacher']);

    /
    if ($student) {
        $query->where('batch_id', $student->batch_id);
    }

    $lectures = $query->latest('lecture_date')->latest('id')->paginate(25);

    return view('pages.lectures.index', compact('lectures', 'student'));
}
    public function create()
    {
        if (auth()->user()->student) abort(403);

        $batches = Batch::where('status', 1)->get();
        $syllabuses = Syllabus::where('status', 1)->get();

        return view('pages.lectures.create', compact('batches', 'syllabuses'));
    }

   public function store(Request $request)
{
    $data = $this->validateLecture($request);
    $data['teacher_id'] = auth()->id();

    // ✅ PDF logic: upload > syllabus auto
    $data['pdf_path'] = $this->resolvePdf($request, $data['syllabus_id'], null);

    DailyLecture::create($data);

    return redirect()->route('lectures.index')->with('success', 'Lecture added successfully!');
}

public function update(Request $request, DailyLecture $lecture)
{
    $data = $this->validateLecture($request);

    // 
    $data['pdf_path'] = $this->resolvePdf($request, $data['syllabus_id'], $lecture->pdf_path);

    $lecture->update($data);

    return redirect()->route('lectures.index')->with('success', 'Lecture updated successfully!');
}

public function destroy(DailyLecture $lecture)
{
  
    if ($lecture->pdf_path
        && str_starts_with($lecture->pdf_path, 'lectures/')
        && Storage::disk('public')->exists($lecture->pdf_path)) {
        Storage::disk('public')->delete($lecture->pdf_path);
    }

    $lecture->delete();

    return redirect()->route('lectures.index')->with('success', 'Lecture deleted successfully!');
}

protected function resolvePdf(Request $request, $syllabusId, ?string $oldPath): ?string
{

    if ($request->hasFile('pdf')) {
       
        if ($oldPath && str_starts_with($oldPath, 'lectures/') && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
        return $request->file('pdf')->store('lectures', 'public');
    }

    
    $syllabus = Syllabus::find($syllabusId);

    if ($syllabus && $syllabus->pdf_path) {
    
        if ($oldPath && str_starts_with($oldPath, 'lectures/') && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }
        return $syllabus->pdf_path;
    }

  
    return $oldPath;
}
    protected function validateLecture(Request $request): array
    {
        return $request->validate([
            'batch_id' => 'required|exists:batches,id',
            'syllabus_id' => 'required|exists:syllabuses,id',
            'lecture_date' => 'required|date',
            'comments' => 'nullable|string',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);
    }
}