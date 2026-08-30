<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Driver;
use App\Models\Trailer;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class QuickCreateController extends Controller
{
    public function driver(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $data['user_id'] = auth()->id();
        $data['password'] = Hash::make(Str::random(12)); // temporary password

        $driver = Driver::create($data);

        return response()->json([
            'id' => $driver->id,
            'label' => trim($driver->first_name . ' ' . $driver->last_name),
        ], 201);
    }

    public function company(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $data['user_id'] = auth()->id();

        $company = Company::create($data);

        return response()->json(['id' => $company->id, 'label' => $company->name], 201);
    }

    public function truck(Request $request)
    {
        $data = $request->validate(['unit_number' => 'required|string|max:100']);

        $truck = Truck::create([
            'user_id' => auth()->id(),
            'unit_number' => $data['unit_number'],
            'status' => 'Available',
        ]);

        return response()->json(['id' => $truck->id, 'label' => $truck->unit_number], 201);
    }

    public function trailer(Request $request)
    {
        $data = $request->validate([
            'trailer_number' => 'required|string|max:100',
            'ownership_type' => 'required|in:Company Owned,Self Owned',
        ]);

        $trailer = Trailer::create([
            'user_id' => auth()->id(),
            'trailer_number' => $data['trailer_number'],
            'ownership_type' => $data['ownership_type'],
            'status' => true,
        ]);

        return response()->json(['id' => $trailer->id, 'label' => $trailer->trailer_number], 201);
    }
}