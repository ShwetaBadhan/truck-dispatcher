<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query()->with(['country', 'state', 'city', 'user']);

        // My Companies filter
        if ($request->input('filter') === 'my') {
            $query->where('user_id', auth()->id());
        }

        // Search (Name / Phone / MC Number)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%")
                  ->orWhere('motor_carrier_number', 'like', "%{$search}%");
            });
        }

        // Location filters
        if ($request->filled('country_id')) $query->where('country_id', $request->input('country_id'));
        if ($request->filled('state_id')) $query->where('state_id', $request->input('state_id'));
        if ($request->filled('city_id')) $query->where('city_id', $request->input('city_id'));

        $companies = $query->latest()->paginate(10)->withQueryString();

        $countries = Country::where('status', 1)->orderBy('name')->get();
        $states = State::where('status', 1)
            ->when($request->filled('country_id'), fn($q) => $q->where('country_id', $request->input('country_id')))
            ->orderBy('name')->get();
        $cities = City::where('status', 1)
            ->when($request->filled('state_id'), fn($q) => $q->where('state_id', $request->input('state_id')))
            ->orderBy('name')->get();

        return view('pages.companies.index', compact('companies', 'countries', 'states', 'cities'));
    }

    public function show(Company $company)
    {
        $company->load(['country', 'state', 'city', 'user']);
        return view('pages.companies.show', compact('company'));
    }

    public function create()
    {
        $countries = Country::where('status', 1)->orderBy('name')->get();
        $states = collect();
        $cities = collect();

        return view('pages.companies.create', compact('countries', 'states', 'cities'));
    }

    public function store(Request $request)
    {
        $data = $this->validateCompany($request);
        $data['user_id'] = auth()->id(); // ✅ Owner set

        Company::create($data);

        return redirect()->route('companies.index')->with('success', 'Company created successfully!');
    }

    public function edit(Company $company)
    {
        if ($redirect = $this->ensureOwner($company)) return $redirect;

        $countries = Country::where('status', 1)->orderBy('name')->get();
        $states = State::where('country_id', $company->country_id)->orderBy('name')->get();
        $cities = City::where('state_id', $company->state_id)->orderBy('name')->get();

        return view('pages.companies.edit', compact('company', 'countries', 'states', 'cities'));
    }

    public function update(Request $request, Company $company)
    {
        if ($redirect = $this->ensureOwner($company)) return $redirect;

        $company->update($this->validateCompany($request));

        return redirect()->route('companies.show', $company->id)->with('success', 'Company updated successfully!');
    }

    public function destroy(Company $company)
    {
        if ($redirect = $this->ensureOwner($company)) return $redirect;

        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully!');
    }

    // ===== Helpers =====
    protected function ensureOwner(Company $company)
    {
        if ($company->user_id !== auth()->id()) {
            return redirect()->route('companies.index')->with('error', 'You can only manage your own companies!');
        }
        return null;
    }

    protected function validateCompany(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
            'apt_suite_other' => 'nullable|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'zip_code' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'motor_carrier_number' => 'nullable|string|max:100',
            'tax_id' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);
    }
}