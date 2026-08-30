<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Country;
use App\Models\Dispatch;
use App\Models\Driver;
use App\Models\Trailer;
use App\Models\Truck;
use Illuminate\Http\Request;

class DispatchController extends Controller
{
    public function index(Request $request)
    {
        $query = Dispatch::query()->with(['driver', 'truck', 'user']);

        if ($request->input('filter') === 'my') {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('trip_name', 'like', "%{$search}%")
                  ->orWhereHas('driver', fn($qq) => $qq->where('first_name', 'like', "%{$search}%"))
                  ->orWhereHas('truck', fn($qq) => $qq->where('unit_number', 'like', "%{$search}%"));
            });
        }

        $dispatches = $query->latest()->paginate(10)->withQueryString();

        return view('pages.dispatches.index', compact('dispatches'));
    }

    public function show(Dispatch $dispatch)
    {
        $dispatch->load(['user', 'driver', 'customer', 'truck', 'trailer',
            'teamMembers.driver',
            'pickups.shipper', 'pickups.country', 'pickups.state', 'pickups.city',
            'deliveries.consignee', 'deliveries.country', 'deliveries.state', 'deliveries.city']);

        return view('pages.dispatches.show', compact('dispatch'));
    }

    public function create()
    {
        return view('pages.dispatches.create', $this->formData());
    }

    public function store(Request $request)
    {
        $data = $this->calculateInvoice($this->validateDispatch($request));
        $data['user_id'] = auth()->id();

        $dispatch = Dispatch::create($data);
        $this->saveChildren($request, $dispatch);

        return redirect()->route('dispatches.index')->with('success', 'Dispatch created successfully!');
    }

    public function edit(Dispatch $dispatch)
    {
        if ($redirect = $this->ensureOwner($dispatch)) return $redirect;

        $dispatch->load(['teamMembers', 'pickups', 'deliveries']);

        return view('pages.dispatches.edit', array_merge($this->formData(), ['dispatch' => $dispatch]));
    }

    public function update(Request $request, Dispatch $dispatch)
    {
        if ($redirect = $this->ensureOwner($dispatch)) return $redirect;

        $dispatch->update($this->calculateInvoice($this->validateDispatch($request)));

        // Simple sync: purani rows delete, nayi save
        $dispatch->teamMembers()->delete();
        $dispatch->pickups()->delete();
        $dispatch->deliveries()->delete();
        $this->saveChildren($request, $dispatch);

        return redirect()->route('dispatches.show', $dispatch->id)->with('success', 'Dispatch updated successfully!');
    }

    public function destroy(Dispatch $dispatch)
    {
        if ($redirect = $this->ensureOwner($dispatch)) return $redirect;

        $dispatch->delete();

        return redirect()->route('dispatches.index')->with('success', 'Dispatch deleted successfully!');
    }

    // ================= Helpers =================
    protected function ensureOwner(Dispatch $dispatch)
    {
        if ($dispatch->user_id !== auth()->id()) {
            return redirect()->route('dispatches.index')->with('error', 'You can only manage your own dispatches!');
        }
        return null;
    }

    protected function formData(): array
    {
        return [
            'drivers' => Driver::latest()->get(),
            'companies' => Company::orderBy('name')->get(),   // Customer, Shipper, Consignee
            'trucks' => Truck::orderBy('unit_number')->get(),
            'trailers' => Trailer::orderBy('trailer_number')->get(),
            'countries' => Country::where('status', 1)->orderBy('name')->get(),
            'feeTypes' => ['Flat', 'Per Mile', 'Per Hour', 'Per Load'],
            'fscTypes' => ['Flat Fee', 'Per Mile'],
            'pickupTypes' => ['Pickup', 'Drop & Hook', 'Live Load', 'Drop'],
            'accessoryFees' => Dispatch::ACCESSORY_FEES,
        ];
    }

    protected function validateDispatch(Request $request): array
    {
        $request->validate([
            'trip_name' => 'required|string|max:255',
            'driver_id' => 'required|exists:drivers,id',
            'customer_id' => 'required|exists:companies,id',
            'truck_id' => 'required|exists:trucks,id',
            'trailer_id' => 'nullable|exists:trailers,id',
            'team.*.driver_id' => 'nullable|exists:drivers,id',
            'pickups.*.shipper_id' => 'nullable|exists:companies,id',
            'pickups.*.pickup_date' => 'nullable|date',
            'deliveries.*.consignee_id' => 'nullable|exists:companies,id',
            'deliveries.*.delivery_date' => 'nullable|date',
        ]);

        $base = ['trip_name', 'driver_id', 'customer_id', 'manual_pay', 'accessory_driver_pay', 'driver_advance',
            'truck_id', 'trailer_id', 'beginning_odometer', 'loaded_miles', 'deadhead_miles',
            'primary_fee', 'primary_fee_type', 'fuel_surcharge_enabled', 'fsc_amount', 'fsc_amount_type', 'invoice_advance'];

        return $request->only(array_merge($base, array_keys(Dispatch::ACCESSORY_FEES)));
    }

    // ✅ Invoice auto-calculation (server side)
    protected function calculateInvoice(array $data): array
    {
        $accessory = 0;
        foreach (array_keys(Dispatch::ACCESSORY_FEES) as $field) {
            $accessory += (float) ($data[$field] ?? 0);
        }

        $primary = (float) ($data['primary_fee'] ?? 0);
        $fsc = ! empty($data['fuel_surcharge_enabled']) ? (float) ($data['fsc_amount'] ?? 0) : 0;
        $advance = (float) ($data['invoice_advance'] ?? 0);

        $data['fuel_surcharge_enabled'] = ! empty($data['fuel_surcharge_enabled']);
        $data['primary_charges'] = $primary;
        $data['fuel_surcharge'] = $fsc;
        $data['accessory_fees'] = $accessory;
        $data['invoice_total'] = $primary + $fsc + $accessory + $advance;
        $data['total_miles'] = ((float) ($data['loaded_miles'] ?? 0)) + ((float) ($data['deadhead_miles'] ?? 0));

        return $data;
    }

    protected function saveChildren(Request $request, Dispatch $dispatch): void
    {
        foreach ($request->input('team', []) as $row) {
            if (! empty($row['driver_id'])) {
                $dispatch->teamMembers()->create([
                    'driver_id' => $row['driver_id'],
                    'accessory_driver_pay' => $row['accessory_driver_pay'] ?? null,
                    'driver_advance' => $row['driver_advance'] ?? null,
                ]);
            }
        }

        foreach ($request->input('pickups', []) as $row) {
            if (! empty($row['shipper_id'])) {
                $dispatch->pickups()->create([
                    'shipper_id' => $row['shipper_id'], 'pickup_date' => $row['pickup_date'] ?? null,
                    'street' => $row['street'] ?? null, 'weight' => $row['weight'] ?? null,
                    'quantity' => $row['quantity'] ?? null, 'country_id' => $row['country_id'] ?? null,
                    'state_id' => $row['state_id'] ?? null, 'city_id' => $row['city_id'] ?? null,
                    'type' => $row['type'] ?? null, 'instructions' => $row['instructions'] ?? null,
                    'notes' => $row['notes'] ?? null,
                ]);
            }
        }

        foreach ($request->input('deliveries', []) as $row) {
            if (! empty($row['consignee_id'])) {
                $dispatch->deliveries()->create([
                    'consignee_id' => $row['consignee_id'], 'delivery_date' => $row['delivery_date'] ?? null,
                    'street' => $row['street'] ?? null, 'country_id' => $row['country_id'] ?? null,
                    'state_id' => $row['state_id'] ?? null, 'city_id' => $row['city_id'] ?? null,
                    'instructions' => $row['instructions'] ?? null,
                ]);
            }
        }
    }
    public function invoice(Dispatch $dispatch)
{
    $dispatch->load(['user', 'driver', 'customer', 'truck', 'trailer',
        'teamMembers.driver',
        'pickups.shipper', 'pickups.country', 'pickups.state', 'pickups.city',
        'deliveries.consignee', 'deliveries.country', 'deliveries.state', 'deliveries.city']);

    return view('pages.dispatches.invoice', compact('dispatch'));
}
}