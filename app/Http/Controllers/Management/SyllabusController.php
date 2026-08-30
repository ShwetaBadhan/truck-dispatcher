<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SyllabusController extends Controller
{
    public function index(Request $request)
    {
        $query = Syllabus::query()->with('user');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('topic', 'like', "%{$search}%")
                  ->orWhere('short_details', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $syllabuses = $query->latest()->paginate(10)->withQueryString();

        return view('pages.syllabuses.index', compact('syllabuses'));
    }

    public function create()
    {
        return view('pages.syllabuses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'short_details' => 'nullable|string',
            'pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('syllabuses', 'public');
        }

        unset($data['pdf']);

        $data['user_id'] = auth()->id();

        Syllabus::create($data);

        return redirect()->route('syllabuses.index')->with('success', 'Syllabus created successfully!');
    }

    public function show(Syllabus $syllabus)
    {
        $syllabus->load('user');

        return view('pages.syllabuses.show', compact('syllabus'));
    }

    public function edit(Syllabus $syllabus)
    {
        return view('pages.syllabuses.edit', compact('syllabus'));
    }

    public function update(Request $request, Syllabus $syllabus)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'short_details' => 'nullable|string',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('pdf')) {
            if ($syllabus->pdf_path && Storage::disk('public')->exists($syllabus->pdf_path)) {
                Storage::disk('public')->delete($syllabus->pdf_path);
            }

            $data['pdf_path'] = $request->file('pdf')->store('syllabuses', 'public');
        }

        unset($data['pdf']);

        $syllabus->update($data);

        return redirect()->route('syllabuses.show', $syllabus->id)->with('success', 'Syllabus updated successfully!');
    }

    public function destroy(Syllabus $syllabus)
    {
        if ($syllabus->pdf_path && Storage::disk('public')->exists($syllabus->pdf_path)) {
            Storage::disk('public')->delete($syllabus->pdf_path);
        }

        $syllabus->delete();

        return redirect()->route('syllabuses.index')->with('success', 'Syllabus deleted successfully!');
    }
}