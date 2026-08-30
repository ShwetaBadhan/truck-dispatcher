<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('batch')->latest()->get();
        $batches = Batch::where('status', 1)->orderBy('name')->get();

        return view('pages.students.index', compact('students', 'batches'));
    }

    public function create()
    {
        return view('pages.students.create');
    }

    
   public function store(Request $request)
{
    $data = $this->validateStudent($request);

    $existingUser = User::where('email', $data['email'])->first();

    $studentData = [
        'user_id' => $existingUser?->id,   
        'name' => $data['name'],
        'email' => $data['email'],
        'phone' => $data['phone'] ?? null,
        'father_name' => $data['father_name'] ?? null,
        'mother_name' => $data['mother_name'] ?? null,
        'address' => $data['address'] ?? null,
        'status' => true,
    ];

    $studentData['photo_path'] = $this->storeFile($request, 'photo', 'students/photos', null);
    $studentData['matric_pdf'] = $this->storeFile($request, 'matric_pdf', 'students/documents', null);
    $studentData['tenth_pdf'] = $this->storeFile($request, 'tenth_pdf', 'students/documents', null);
    $studentData['aadhaar_pdf'] = $this->storeFile($request, 'aadhaar_pdf', 'students/documents', null);

    Student::create($studentData);

    // User ko student role de do
    if ($existingUser && !collect($existingUser->getRoleNames())->map(fn($r) => strtolower($r))->contains('student')) {
        $existingUser->assignRole('student');
    }

    return redirect()->route('students.index')->with('success', 'Student registered successfully!');
}
    public function edit(Student $student)
    {
        return view('pages.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $this->validateStudent($request, $student);

        if ($photo = $this->storeFile($request, 'photo', 'students/photos', $student->photo_path)) $data['photo_path'] = $photo;
        if ($matric = $this->storeFile($request, 'matric_pdf', 'students/documents', $student->matric_pdf)) $data['matric_pdf'] = $matric;
        if ($tenth = $this->storeFile($request, 'tenth_pdf', 'students/documents', $student->tenth_pdf)) $data['tenth_pdf'] = $tenth;
        if ($aadhaar = $this->storeFile($request, 'aadhaar_pdf', 'students/documents', $student->aadhaar_pdf)) $data['aadhaar_pdf'] = $aadhaar;

        $student->update($data);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    public function assignBatch(Request $request, Student $student)
    {
        $request->validate(['batch_id' => 'required|exists:batches,id']);

        $student->update(['batch_id' => $request->batch_id]);

        return back()->with('success', 'Batch assigned to ' . $student->name . '!');
    }

    public function destroy(Student $student)
    {
        
        foreach (['photo_path', 'matric_pdf', 'tenth_pdf', 'aadhaar_pdf'] as $f) {
            if ($student->$f && Storage::disk('public')->exists($student->$f)) {
                Storage::disk('public')->delete($student->$f);
            }
        }

        $student->delete();

        return back()->with('success', 'Student deleted successfully!');
    }

    // ===== Helpers =====
    protected function validateStudent(Request $request, ?Student $student = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email' . ($student ? ',' . $student->id : ''),
            'phone' => 'required|string|max:20',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'matric_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'tenth_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'aadhaar_pdf' => 'nullable|file|mimes:pdf|max:5120',
        ]);
    }

    protected function storeFile(Request $request, string $field, string $folder, ?string $oldPath): ?string
    {
        if (!$request->hasFile($field)) return null;

        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return $request->file($field)->store($folder, 'public');
    }
}