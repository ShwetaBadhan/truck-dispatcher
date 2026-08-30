<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Trailer;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    public function index(Request $request)
    {
        $query = Trailer::query()->with('user');

        // My Trailers filter
        if ($request->input('filter') === 'my') {
            $query->where('user_id', auth()->id());
        }

        // Search (Number / VIN)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('trailer_number', 'like', "%{$search}%")
                  ->orWhere('vin', 'like', "%{$search}%")
                  ->orWhere('license_plate_number', 'like', "%{$search}%");
            });
        }

        // Ownership filter
        if ($request->filled('ownership_type')) {
            $query->where('ownership_type', $request->input('ownership_type'));
        }

        $trailers = $query->latest()->paginate(10)->withQueryString();
        $ownershipTypes = $this->ownershipTypes();

        return view('pages.trailers.index', compact('trailers', 'ownershipTypes'));
    }

    public function show(Trailer $trailer)
    {
        $trailer->load('user');
        return view('pages.trailers.show', compact('trailer'));
    }

    public function create()
    {
        $ownershipTypes = $this->ownershipTypes();
        return view('pages.trailers.create', compact('ownershipTypes'));
    }

    public function store(Request $request)
    {
        $data = $this->validateTrailer($request);
        $data['user_id'] = auth()->id(); // ✅ Owner set

        Trailer::create($data);

        return redirect()->route('trailers.index')->with('success', 'Trailer created successfully!');
    }

    public function edit(Trailer $trailer)
    {
        if ($redirect = $this->ensureOwner($trailer)) return $redirect;

        $ownershipTypes = $this->ownershipTypes();
        return view('pages.trailers.edit', compact('trailer', 'ownershipTypes'));
    }

    public function update(Request $request, Trailer $trailer)
    {
        if ($redirect = $this->ensureOwner($trailer)) return $redirect;

        $trailer->update($this->validateTrailer($request));

        return redirect()->route('trailers.show', $trailer->id)->with('success', 'Trailer updated successfully!');
    }

    public function destroy(Trailer $trailer)
    {
        if ($redirect = $this->ensureOwner($trailer)) return $redirect;

        $trailer->delete();

        return redirect()->route('trailers.index')->with('success', 'Trailer deleted successfully!');
    }

    // ===== Helpers =====
    protected function ensureOwner(Trailer $trailer)
    {
        if ($trailer->user_id !== auth()->id()) {
            return redirect()->route('trailers.index')->with('error', 'You can only manage your own trailers!');
        }
        return null;
    }

    protected function ownershipTypes(): array
    {
        return ['Company Owned', 'Self Owned'];
    }

    protected function validateTrailer(Request $request): array
    {
        return $request->validate([
            'trailer_number' => 'required|string|max:100',
            'vin' => 'nullable|string|max:50',
            'ownership_type' => 'required|in:Company Owned,Self Owned',
            'status' => 'required|boolean',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1950|max:2027',
            'year_purchased' => 'nullable|integer|min:1950|max:2027',
            'purchase_price' => 'nullable|numeric|min:0',
            'license_plate_number' => 'nullable|string|max:50',
            'license_plate_expiration' => 'nullable|date',
            'inspection_sticker_expiration' => 'nullable|date',
            'insurance_expiration' => 'nullable|date',
        ]);
    }
}