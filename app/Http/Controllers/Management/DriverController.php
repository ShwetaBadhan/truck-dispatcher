<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Driver;
use App\Models\State;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = Driver::query()->with(['country', 'state', 'city', 'user']);

        // My Drivers filter
        if ($request->input('filter') === 'my') {
            $query->where('user_id', auth()->id());
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('country_id')) $query->where('country_id', $request->input('country_id'));
        if ($request->filled('state_id')) $query->where('state_id', $request->input('state_id'));
        if ($request->filled('city_id')) $query->where('city_id', $request->input('city_id'));
        if ($request->filled('payment_type')) $query->where('payment_type', $request->input('payment_type'));

        $drivers = $query->latest()->paginate(10)->withQueryString();

        $countries = Country::where('status', 1)->orderBy('name')->get();
        $states = State::where('status', 1)
            ->when($request->filled('country_id'), fn($q) => $q->where('country_id', $request->input('country_id')))
            ->orderBy('name')->get();
        $cities = City::where('status', 1)
            ->when($request->filled('state_id'), fn($q) => $q->where('state_id', $request->input('state_id')))
            ->orderBy('name')->get();
        $paymentTypes = $this->paymentTypes();

        return view('pages.drivers.index', compact('drivers', 'countries', 'states', 'cities', 'paymentTypes'));
    }

    public function show(Driver $driver)
    {
        $driver->load(['country', 'state', 'city', 'user']);
        return view('pages.drivers.show', compact('driver'));
    }

    public function create()
    {
        $countries = Country::where('status', 1)->orderBy('name')->get();
        $states = collect();
        $cities = collect();
        $paymentTypes = $this->paymentTypes();

        return view('pages.drivers.create', compact('countries', 'states', 'cities', 'paymentTypes'));
    }

    public function store(Request $request)
    {
        $data = $this->validateDriver($request);
        $data['user_id'] = auth()->id();

        Driver::create($data);

        return redirect()->route('drivers.index')->with('success', 'Driver created successfully!');
    }

    public function edit(Driver $driver)
    {
        if ($redirect = $this->ensureOwner($driver)) return $redirect;

        $countries = Country::where('status', 1)->orderBy('name')->get();
        $states = State::where('country_id', $driver->country_id)->orderBy('name')->get();
        $cities = City::where('state_id', $driver->state_id)->orderBy('name')->get();
        $paymentTypes = $this->paymentTypes();

        return view('pages.drivers.edit', compact('driver', 'countries', 'states', 'cities', 'paymentTypes'));
    }

    public function update(Request $request, Driver $driver)
    {
        if ($redirect = $this->ensureOwner($driver)) return $redirect;

        $driver->update($this->validateDriver($request));

        return redirect()->route('drivers.show', $driver->id)->with('success', 'Driver updated successfully!');
    }

    public function destroy(Driver $driver)
    {
        if ($redirect = $this->ensureOwner($driver)) return $redirect;

        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Driver deleted successfully!');
    }

    // ===== AJAX =====
    public function getStates($countryId)
    {
        return response()->json(State::where('country_id', $countryId)->where('status', 1)->orderBy('name')->get(['id', 'name']));
    }

    public function getCities($stateId)
    {
        return response()->json(City::where('state_id', $stateId)->where('status', 1)->orderBy('name')->get(['id', 'name']));
    }

    // ===== Helpers =====
    protected function ensureOwner(Driver $driver)
    {
        if ($driver->user_id !== auth()->id()) {
            return redirect()->route('drivers.index')->with('error', 'You can only manage your own drivers!');
        }
        return null;
    }

    protected function paymentTypes(): array
    {
        return ['Load Pay Percent', 'Mile Pay', 'Hourly Pay', 'Salary', 'Cash', 'Bank Transfer', 'Other'];
    }

    protected function validateDriver(Request $request): array
    {
        return $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'zip_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'payment_type' => 'required|string|max:100',
            'license_number' => 'required|string|max:100',
            'license_expiration' => 'nullable|date',
            'license_issuing_state' => 'nullable|string|max:100',
            'medical_card_renewal' => 'nullable|date',
            'hire_date' => 'nullable|date',
            'termination_date' => 'nullable|date',
            'emergency_contact' => 'nullable|string',
        ]);
    }
}