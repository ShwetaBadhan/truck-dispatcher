<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::withCount('students')->latest()->get();
        return view('pages.batches.index', compact('batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:batches,name',
            'status' => 'required|boolean',
        ]);

        Batch::create($request->only(['name', 'status']));

        return back()->with('success', 'Batch created successfully!');
    }

    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:batches,name,' . $batch->id,
            'status' => 'required|boolean',
        ]);

        $batch->update($request->only(['name', 'status']));

        return back()->with('success', 'Batch updated successfully!');
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return back()->with('success', 'Batch deleted successfully!');
    }
}