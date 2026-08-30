<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    public function index(Request $request)
    {
        $query = Truck::query()->with('user');

        // My Trucks filter
        if ($request->input('filter') === 'my') {
            $query->where('user_id', auth()->id());
        }

        // Search (Unit / VIN / Plate)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('unit_number', 'like', "%{$search}%")
                  ->orWhere('vin', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $trucks = $query->latest()->paginate(10)->withQueryString();
        $statuses = $this->statuses();

        return view('pages.trucks.index', compact('trucks', 'statuses'));
    }

    public function show(Truck $truck)
    {
        $truck->load('user');
        return view('pages.trucks.show', compact('truck'));
    }

    public function create()
    {
        $statuses = $this->statuses();
        return view('pages.trucks.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $data = $this->validateTruck($request);
        $data['user_id'] = auth()->id(); // ✅ Owner set

        Truck::create($data);

        return redirect()->route('trucks.index')->with('success', 'Truck created successfully!');
    }

    public function edit(Truck $truck)
    {
        if ($redirect = $this->ensureOwner($truck)) return $redirect;

        $statuses = $this->statuses();
        return view('pages.trucks.edit', compact('truck', 'statuses'));
    }

    public function update(Request $request, Truck $truck)
    {
        if ($redirect = $this->ensureOwner($truck)) return $redirect;

        $truck->update($this->validateTruck($request));

        return redirect()->route('trucks.show', $truck->id)->with('success', 'Truck updated successfully!');
    }

    public function destroy(Truck $truck)
    {
        if ($redirect = $this->ensureOwner($truck)) return $redirect;

        $truck->delete();

        return redirect()->route('trucks.index')->with('success', 'Truck deleted successfully!');
    }

    // ===== Helpers =====
    protected function ensureOwner(Truck $truck)
    {
        if ($truck->user_id !== auth()->id()) {
            return redirect()->route('trucks.index')->with('error', 'You can only manage your own trucks!');
        }
        return null;
    }

    protected function statuses(): array
    {
        return ['Available', 'In Service', 'Out of Service'];
    }

    protected function validateTruck(Request $request): array
    {
        return $request->validate([
            'unit_number' => 'required|string|max:100',
            'status' => 'required|in:Available,In Service,Out of Service',
            'vin' => 'nullable|string|max:50',
            'make' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'plate_number' => 'nullable|string|max:50',
            'plate_state' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1950|max:2027',
            'capacity_lbs' => 'nullable|integer|min:0',
        ]);
    }
}