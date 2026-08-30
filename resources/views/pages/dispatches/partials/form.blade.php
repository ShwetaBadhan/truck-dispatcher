@php
    $d = $dispatch ?? null;
    $teamRows = $d ? $d->teamMembers : collect();
    $pickupRows = $d ? $d->pickups : collect();
    $deliveryRows = $d ? $d->deliveries : collect();
@endphp

<form action="{{ $d ? route('dispatches.update', $d->id) : route('dispatches.store') }}" method="POST" id="dispatchForm">
@csrf
@if($d) @method('PUT') @endif

{{-- ============ TRIP SETUP ============ --}}
<div class="wg-box p-20 mb-20">
    <h5 class="mb-10">TRIP SETUP</h5>
    <div class="text-tiny mb-20">Select the main driver, equipment, and customer for this trip.</div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Trip Name <span class="tf-color-1">*</span></label>
            <input type="text" name="trip_name" class="form-control" value="{{ old('trip_name', $d?->trip_name) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Select Driver <span class="tf-color-1">*</span></label>
            <select name="driver_id" class="select" required>
                <option value="">Select Driver</option>
                @foreach ($drivers as $dr)
                    <option value="{{ $dr->id }}" @selected(old('driver_id', $d?->driver_id) == $dr->id)>{{ $dr->first_name }} {{ $dr->last_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Customer <span class="tf-color-1">*</span></label>
            <select name="customer_id" class="select" required>
                <option value="">Select Customer</option>
                @foreach ($companies as $c)
                    <option value="{{ $c->id }}" @selected(old('customer_id', $d?->customer_id) == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 mb-3">
            <label class="body-title mb-10 d-block">Manual Pay ($)</label>
            <input type="number" step="0.01" name="manual_pay" class="form-control" value="{{ old('manual_pay', $d?->manual_pay) }}">
        </div>
        <div class="col-md-2 mb-3">
            <label class="body-title mb-10 d-block">Accessory Driver Pay ($)</label>
            <input type="number" step="0.01" name="accessory_driver_pay" class="form-control" value="{{ old('accessory_driver_pay', $d?->accessory_driver_pay) }}">
        </div>
        <div class="col-md-2 mb-3">
            <label class="body-title mb-10 d-block">Driver Advance ($)</label>
            <input type="number" step="0.01" name="driver_advance" class="form-control" value="{{ old('driver_advance', $d?->driver_advance) }}">
        </div>
    </div>
</div>

{{-- ============ CREATE TEAM ============ --}}
<div class="wg-box p-20 mb-20">
    <div class="flex items-center justify-between gap10 mb-20" style="display:flex; justify-content:space-between;">
        <div>
            <h5 class="mb-0">CREATE TEAM</h5>
            <div class="text-tiny">Add teammate drivers only when this dispatch needs them.</div>
        </div>
        <button type="button" id="addTeam" class="tf-button">Add Team Member</button>
    </div>

    <div id="teamContainer">
        @foreach ($teamRows as $i => $row)
            <div class="row stop-row align-items-end mb-15">
                <div class="col-md-5">
                    <label class="body-title mb-10 d-block">Team Driver</label>
                    <select name="team[{{ $i }}][driver_id]" class="select">
                        <option value="">Select Team Member</option>
                        @foreach ($drivers as $dr)
                            <option value="{{ $dr->id }}" @selected($row->driver_id == $dr->id)>{{ $dr->first_name }} {{ $dr->last_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="body-title mb-10 d-block">Accessory Driver Pay ($)</label>
                    <input type="number" step="0.01" name="team[{{ $i }}][accessory_driver_pay]" class="form-control" value="{{ $row->accessory_driver_pay }}">
                </div>
                <div class="col-md-3">
                    <label class="body-title mb-10 d-block">Driver Advance ($)</label>
                    <input type="number" step="0.01" name="team[{{ $i }}][driver_advance]" class="form-control" value="{{ $row->driver_advance }}">
                </div>
                <div class="col-md-1">
                    <button type="button" class="remove-row item trash" style="background: none; border: none; cursor: pointer; color: #dc3545;">
                                                        <i class="icon-trash-2"></i></button>
                </div>
            </div>
        @endforeach
    </div>

    <template id="tplTeam">
        <div class="row stop-row align-items-end mb-15">
            <div class="col-md-5">
                <label class="body-title mb-10 d-block">Team Driver</label>
                <select name="team[__INDEX__][driver_id]" class="select">
                    <option value="">Select Team Member</option>
                    @foreach ($drivers as $dr)
                        <option value="{{ $dr->id }}">{{ $dr->first_name }} {{ $dr->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="body-title mb-10 d-block">Accessory Driver Pay ($)</label>
                <input type="number" step="0.01" name="team[__INDEX__][accessory_driver_pay]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="body-title mb-10 d-block">Driver Advance ($)</label>
                <input type="number" step="0.01" name="team[__INDEX__][driver_advance]" class="form-control">
            </div>
            <div class="col-md-1">
                   <button type="button" class="remove-row item trash" style="background: none; border: none; cursor: pointer; color: #dc3545;">
                                                        <i class="icon-trash-2"></i></button>
            </div>
        </div>
    </template>
</div>

{{-- ============ EQUIPMENT ============ --}}
<div class="wg-box p-20 mb-20">
    <h5 class="mb-10">EQUIPMENT</h5>
    <div class="text-tiny mb-20">Assign the truck and trailer that will run this trip.</div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Truck <span class="tf-color-1">*</span></label>
            <select name="truck_id" class="select" required>
                <option value="">Select Truck</option>
                @foreach ($trucks as $t)
                    <option value="{{ $t->id }}" @selected(old('truck_id', $d?->truck_id) == $t->id)>{{ $t->unit_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Trailer</label>
            <select name="trailer_id" class="select">
                <option value="">Select Trailer</option>
                @foreach ($trailers as $t)
                    <option value="{{ $t->id }}" @selected(old('trailer_id', $d?->trailer_id) == $t->id)>{{ $t->trailer_number }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label class="body-title mb-10 d-block">Beginning Odometer</label>
            <input type="text" name="beginning_odometer" class="form-control" value="{{ old('beginning_odometer', $d?->beginning_odometer) }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="body-title mb-10 d-block">Loaded Miles</label>
            <input type="number" step="0.01" name="loaded_miles" id="loaded_miles" class="form-control" value="{{ old('loaded_miles', $d?->loaded_miles) }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="body-title mb-10 d-block">Deadhead Miles</label>
            <input type="number" step="0.01" name="deadhead_miles" id="deadhead_miles" class="form-control" value="{{ old('deadhead_miles', $d?->deadhead_miles) }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="body-title mb-10 d-block">Total Miles</label>
            <input type="number" step="0.01" name="total_miles" id="total_miles" class="form-control" value="{{ old('total_miles', $d?->total_miles) }}" readonly>
        </div>
    </div>
</div>

{{-- ============ PICKUP STOPS ============ --}}
<div class="wg-box p-20 mb-20">
    <div class="flex items-center justify-between gap10 mb-20" style="display:flex; justify-content:space-between;">
        <div>
            <h5 class="mb-0">PICKUP STOPS</h5>
            <div class="text-tiny">Use one row per pickup.</div>
        </div>
        <button type="button" id="addPickup" class="tf-button">Add Another Pickup</button>
    </div>

    <div id="pickupContainer">
        @foreach ($pickupRows as $i => $row)
            <div class="stop-row border rounded p-15 mb-15" style="border:1px solid #dee2e6 !important; padding:15px; border-radius:8px;">
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <label class="body-title mb-10 d-block">Shipper <span class="tf-color-1">*</span></label>
                        <select name="pickups[{{ $i }}][shipper_id]" class="select">
                            <option value="">Select Shipper</option>
                            @foreach ($companies as $c)
                                <option value="{{ $c->id }}" @selected($row->shipper_id == $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="body-title mb-10 d-block">Pickup Date <span class="tf-color-1">*</span></label>
                        <input type="date" name="pickups[{{ $i }}][pickup_date]" class="form-control" value="{{ $row->pickup_date?->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="body-title mb-10 d-block">Street</label>
                        <input type="text" name="pickups[{{ $i }}][street]" class="form-control" value="{{ $row->street }}">
                    </div>
                    <div class="col-md-1 mb-2 text-end">
                        <button type="button" class="remove-row" style="background:none;border:none;color:#dc3545;cursor:pointer;"><i class="icon-trash-2"></i></button>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="body-title mb-10 d-block">Weight</label>
                        <input type="text" name="pickups[{{ $i }}][weight]" class="form-control" value="{{ $row->weight }}">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="body-title mb-10 d-block">Quantity</label>
                        <input type="text" name="pickups[{{ $i }}][quantity]" class="form-control" value="{{ $row->quantity }}">
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="body-title mb-10 d-block">Country</label>
                        <select name="pickups[{{ $i }}][country_id]" class="select country-select">
                            <option value="">Select Country</option>
                            @foreach ($countries as $c)
                                <option value="{{ $c->id }}" @selected($row->country_id == $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="body-title mb-10 d-block">State</label>
                        <select name="pickups[{{ $i }}][state_id]" class="select state-select">
                            <option value="">Select State</option>
                            @foreach ($row->country?->states ?? [] as $s)
                                <option value="{{ $s->id }}" @selected($row->state_id == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="body-title mb-10 d-block">City</label>
                        <select name="pickups[{{ $i }}][city_id]" class="select city-select">
                            <option value="">Select City</option>
                            @foreach ($row->state?->cities ?? [] as $c)
                                <option value="{{ $c->id }}" @selected($row->city_id == $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="body-title mb-10 d-block">Type</label>
                        <select name="pickups[{{ $i }}][type]" class="select">
                            <option value="">Select Type</option>
                            @foreach ($pickupTypes as $t)
                                <option value="{{ $t }}" @selected($row->type == $t)>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="body-title mb-10 d-block">Instructions</label>
                        <textarea name="pickups[{{ $i }}][instructions]" class="form-control" rows="1">{{ $row->instructions }}</textarea>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="body-title mb-10 d-block">Notes</label>
                        <textarea name="pickups[{{ $i }}][notes]" class="form-control" rows="1">{{ $row->notes }}</textarea>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <template id="tplPickup">
        <div class="stop-row border rounded p-15 mb-15" style="border:1px solid #dee2e6 !important; padding:15px; border-radius:8px;">
            <div class="row">
                <div class="col-md-5 mb-2">
                    <label class="body-title mb-10 d-block">Shipper <span class="tf-color-1">*</span></label>
                    <select name="pickups[__INDEX__][shipper_id]" class="select">
                        <option value="">Select Shipper</option>
                        @foreach ($companies as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="body-title mb-10 d-block">Pickup Date <span class="tf-color-1">*</span></label>
                    <input type="date" name="pickups[__INDEX__][pickup_date]" class="form-control">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="body-title mb-10 d-block">Street</label>
                    <input type="text" name="pickups[__INDEX__][street]" class="form-control">
                </div>
                <div class="col-md-1 mb-2 text-end">
                    <button type="button" class="remove-row" style="background:none;border:none;color:#dc3545;cursor:pointer;"><i class="icon-trash-2"></i></button>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="body-title mb-10 d-block">Weight</label>
                    <input type="text" name="pickups[__INDEX__][weight]" class="form-control">
                </div>
                <div class="col-md-2 mb-2">
                    <label class="body-title mb-10 d-block">Quantity</label>
                    <input type="text" name="pickups[__INDEX__][quantity]" class="form-control">
                </div>
                <div class="col-md-4 mb-2">
                    <label class="body-title mb-10 d-block">Country</label>
                    <select name="pickups[__INDEX__][country_id]" class="select country-select">
                        <option value="">Select Country</option>
                        @foreach ($countries as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="body-title mb-10 d-block">State</label>
                    <select name="pickups[__INDEX__][state_id]" class="select state-select"><option value="">Select State</option></select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="body-title mb-10 d-block">City</label>
                    <select name="pickups[__INDEX__][city_id]" class="select city-select"><option value="">Select City</option></select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="body-title mb-10 d-block">Type</label>
                    <select name="pickups[__INDEX__][type]" class="select">
                        <option value="">Select Type</option>
                        @foreach ($pickupTypes as $t)<option value="{{ $t }}">{{ $t }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="body-title mb-10 d-block">Instructions</label>
                    <textarea name="pickups[__INDEX__][instructions]" class="form-control" rows="1"></textarea>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="body-title mb-10 d-block">Notes</label>
                    <textarea name="pickups[__INDEX__][notes]" class="form-control" rows="1"></textarea>
                </div>
            </div>
        </div>
    </template>
</div>

{{-- ============ DELIVERY STOPS ============ --}}
<div class="wg-box p-20 mb-20">
    <div class="flex items-center justify-between gap10 mb-20" style="display:flex; justify-content:space-between;">
        <div>
            <h5 class="mb-0">DELIVERY STOPS</h5>
            <div class="text-tiny">Add one row per consignee delivery stop.</div>
        </div>
        <button type="button" id="addDelivery" class="tf-button">Add Another Delivery</button>
    </div>

    <div id="deliveryContainer">
        @foreach ($deliveryRows as $i => $row)
            <div class="stop-row border rounded p-15 mb-15" style="border:1px solid #dee2e6 !important; padding:15px; border-radius:8px;">
                <div class="row">
                    <div class="col-md-5 mb-2">
                        <label class="body-title mb-10 d-block">Consignee <span class="tf-color-1">*</span></label>
                        <select name="deliveries[{{ $i }}][consignee_id]" class="select">
                            <option value="">Select Consignee</option>
                            @foreach ($companies as $c)
                                <option value="{{ $c->id }}" @selected($row->consignee_id == $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="body-title mb-10 d-block">Delivery Date <span class="tf-color-1">*</span></label>
                        <input type="date" name="deliveries[{{ $i }}][delivery_date]" class="form-control" value="{{ $row->delivery_date?->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="body-title mb-10 d-block">Street</label>
                        <input type="text" name="deliveries[{{ $i }}][street]" class="form-control" value="{{ $row->street }}">
                    </div>
                    <div class="col-md-1 mb-2 text-end">
                        <button type="button" class="remove-row" style="background:none;border:none;color:#dc3545;cursor:pointer;"><i class="icon-trash-2"></i></button>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="body-title mb-10 d-block">Country</label>
                        <select name="deliveries[{{ $i }}][country_id]" class="select country-select">
                            <option value="">Select Country</option>
                            @foreach ($countries as $c)
                                <option value="{{ $c->id }}" @selected($row->country_id == $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="body-title mb-10 d-block">State</label>
                        <select name="deliveries[{{ $i }}][state_id]" class="select state-select">
                            <option value="">Select State</option>
                            @foreach ($row->country?->states ?? [] as $s)
                                <option value="{{ $s->id }}" @selected($row->state_id == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="body-title mb-10 d-block">City</label>
                        <select name="deliveries[{{ $i }}][city_id]" class="select city-select">
                            <option value="">Select City</option>
                            @foreach ($row->state?->cities ?? [] as $c)
                                <option value="{{ $c->id }}" @selected($row->city_id == $c->id)>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="body-title mb-10 d-block">Instructions</label>
                        <textarea name="deliveries[{{ $i }}][instructions]" class="form-control" rows="1">{{ $row->instructions }}</textarea>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <template id="tplDelivery">
        <div class="stop-row border rounded p-15 mb-15" style="border:1px solid #dee2e6 !important; padding:15px; border-radius:8px;">
            <div class="row">
                <div class="col-md-5 mb-2">
                    <label class="body-title mb-10 d-block">Consignee <span class="tf-color-1">*</span></label>
                    <select name="deliveries[__INDEX__][consignee_id]" class="select">
                        <option value="">Select Consignee</option>
                        @foreach ($companies as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="body-title mb-10 d-block">Delivery Date <span class="tf-color-1">*</span></label>
                    <input type="date" name="deliveries[__INDEX__][delivery_date]" class="form-control">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="body-title mb-10 d-block">Street</label>
                    <input type="text" name="deliveries[__INDEX__][street]" class="form-control">
                </div>
                <div class="col-md-1 mb-2 text-end">
                    <button type="button" class="remove-row" style="background:none;border:none;color:#dc3545;cursor:pointer;"><i class="icon-trash-2"></i></button>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="body-title mb-10 d-block">Country</label>
                    <select name="deliveries[__INDEX__][country_id]" class="select country-select">
                        <option value="">Select Country</option>
                        @foreach ($countries as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="body-title mb-10 d-block">State</label>
                    <select name="deliveries[__INDEX__][state_id]" class="select state-select"><option value="">Select State</option></select>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="body-title mb-10 d-block">City</label>
                    <select name="deliveries[__INDEX__][city_id]" class="select city-select"><option value="">Select City</option></select>
                </div>
                <div class="col-12 mb-2">
                    <label class="body-title mb-10 d-block">Instructions</label>
                    <textarea name="deliveries[__INDEX__][instructions]" class="form-control" rows="1"></textarea>
                </div>
            </div>
        </div>
    </template>
</div>

{{-- ============ FEE CHARGES ============ --}}
<div class="wg-box p-20 mb-20">
    <h5 class="mb-10">FEE CHARGES</h5>
    <div class="text-tiny mb-20">Fuel defaults: 4.91 per/lt and 0.70 per/mile.</div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Primary Fee ($)</label>
            <input type="number" step="0.01" name="primary_fee" id="primary_fee" class="form-control" value="{{ old('primary_fee', $d?->primary_fee) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Primary Fee Type</label>
            <select name="primary_fee_type" class="select">
                <option value="">Select Fee Type</option>
                @foreach ($feeTypes as $t)
                    <option value="{{ $t }}" @selected(old('primary_fee_type', $d?->primary_fee_type) == $t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3 d-flex align-items-center" style="display:flex; align-items:center; gap:10px;">
            <input type="hidden" name="fuel_surcharge_enabled" value="0">
            <input type="checkbox" name="fuel_surcharge_enabled" id="fuel_surcharge_enabled" value="1" @checked(old('fuel_surcharge_enabled', $d?->fuel_surcharge_enabled))>
            <label for="fuel_surcharge_enabled">Fuel Surcharge Fee</label>
        </div>
        <div class="col-md-6 mb-3 fsc-field" style="display:none;">
            <label class="body-title mb-10 d-block">FSC Amount ($)</label>
            <input type="number" step="0.01" name="fsc_amount" id="fsc_amount" class="form-control" value="{{ old('fsc_amount', $d?->fsc_amount) }}">
        </div>
        <div class="col-md-6 mb-3 fsc-field" style="display:none;">
            <label class="body-title mb-10 d-block">FSC Amount Type</label>
            <select name="fsc_amount_type" class="select">
                <option value="">Select FSC Type</option>
                @foreach ($fscTypes as $t)
                    <option value="{{ $t }}" @selected(old('fsc_amount_type', $d?->fsc_amount_type) == $t)>{{ $t }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Invoice Advance ($)</label>
            <input type="number" step="0.01" name="invoice_advance" id="invoice_advance" class="form-control" value="{{ old('invoice_advance', $d?->invoice_advance) }}">
        </div>
    </div>

    <h6 class="mt-20 mb-15">ACCESSORY FEES</h6>
    <div class="row">
        @foreach ($accessoryFees as $field => $label)
            <div class="col-md-6 mb-3">
                <label class="body-title mb-10 d-block">{{ $label }}</label>
                <input type="number" step="0.01" name="{{ $field }}" class="form-control acc-fee" value="{{ old($field, $d?->$field) }}">
            </div>
        @endforeach
    </div>
</div>

{{-- ============ INVOICE SUMMARY (Auto-Calculated) ============ --}}
<div class="wg-box p-20 mb-20">
    <h5 class="mb-10">INVOICE SUMMARY</h5>
    <div class="text-tiny mb-15">Live invoice estimate based on primary fee, surcharge, accessories, and advance.</div>
    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee;"><span>Primary Charges</span><strong id="sum_primary">$0.00</strong></div>
    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee;"><span>Fuel Surcharge</span><strong id="sum_fsc">$0.00</strong></div>
    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee;"><span>Accessory Fees</span><strong id="sum_acc">$0.00</strong></div>
    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee;"><span>Invoice Advance</span><strong id="sum_advance">$0.00</strong></div>
    <div style="display:flex; justify-content:space-between; padding:10px 0;"><span><strong>Invoice Total</strong></span><strong id="sum_total" style="color:#FF5200;">$0.00</strong></div>
</div>

<div class="flex items-center gap10 mt-20">
    <button type="submit" class="tf-button" style="background: #FF5200; color: white;">{{ $d ? 'Update Dispatch' : 'Save Dispatch' }}</button>
    <a href="{{ route('dispatches.index') }}" class="tf-button" style="background: #6c757d; color: white; text-decoration: none;">Cancel</a>
</div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const statesUrl = "{{ route('ajax.states', ':country') }}";
    const citiesUrl = "{{ route('ajax.cities', ':state') }}";

    let teamIdx = {{ $teamRows->count() }};
    let pickupIdx = {{ $pickupRows->count() }};
    let deliveryIdx = {{ $deliveryRows->count() }};

    // Add Dynamic Rows
    document.getElementById('addTeam').addEventListener('click', function () {
        document.getElementById('teamContainer').insertAdjacentHTML('beforeend',
            document.getElementById('tplTeam').innerHTML.replaceAll('__INDEX__', teamIdx++));
    });
    document.getElementById('addPickup').addEventListener('click', function () {
        document.getElementById('pickupContainer').insertAdjacentHTML('beforeend',
            document.getElementById('tplPickup').innerHTML.replaceAll('__INDEX__', pickupIdx++));
    });
    document.getElementById('addDelivery').addEventListener('click', function () {
        document.getElementById('deliveryContainer').insertAdjacentHTML('beforeend',
            document.getElementById('tplDelivery').innerHTML.replaceAll('__INDEX__', deliveryIdx++));
    });

    // Remove Row
    document.getElementById('dispatchForm').addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-row');
        if (btn) btn.closest('.stop-row').remove();
    });

    // Cascading Country -> State -> City
    document.addEventListener('change', function (e) {
        const t = e.target;
        if (t.classList.contains('country-select')) {
            const row = t.closest('.stop-row') || t.closest('.modal-content');
            const stateSel = row.querySelector('.state-select');
            const citySel = row.querySelector('.city-select');
            stateSel.innerHTML = '<option value="">Select State</option>';
            citySel.innerHTML = '<option value="">Select City</option>';
            if (t.value) {
                fetch(statesUrl.replace(':country', t.value)).then(r => r.json()).then(items => {
                    items.forEach(s => stateSel.add(new Option(s.name, s.id)));
                });
            }
        }
        if (t.classList.contains('state-select')) {
            const row = t.closest('.stop-row') || t.closest('.modal-content');
            const citySel = row.querySelector('.city-select');
            citySel.innerHTML = '<option value="">Select City</option>';
            if (t.value) {
                fetch(citiesUrl.replace(':state', t.value)).then(r => r.json()).then(items => {
                    items.forEach(c => citySel.add(new Option(c.name, c.id)));
                });
            }
        }
    });

    // Auto Invoice Calculation
    const num = el => parseFloat(el ? el.value : 0) || 0;
    const money = n => '$' + n.toFixed(2);

    function recalc() {
        // Total Miles
        const tm = num(document.getElementById('loaded_miles')) + num(document.getElementById('deadhead_miles'));
        document.getElementById('total_miles').value = tm.toFixed(2);

        // Invoice
        const primary = num(document.getElementById('primary_fee'));
        const fscOn = document.getElementById('fuel_surcharge_enabled').checked;
        const fsc = fscOn ? num(document.getElementById('fsc_amount')) : 0;

        let acc = 0;
        document.querySelectorAll('.acc-fee').forEach(i => acc += num(i));

        const adv = num(document.getElementById('invoice_advance'));

        document.getElementById('sum_primary').textContent = money(primary);
        document.getElementById('sum_fsc').textContent = money(fsc);
        document.getElementById('sum_acc').textContent = money(acc);
        document.getElementById('sum_advance').textContent = money(adv);
        document.getElementById('sum_total').textContent = money(primary + fsc + acc + adv);
    }

    // Fuel Surcharge Toggle
    const fscToggle = document.getElementById('fuel_surcharge_enabled');
    function toggleFsc() {
        document.querySelectorAll('.fsc-field').forEach(el => el.style.display = fscToggle.checked ? '' : 'none');
        recalc();
    }
    fscToggle.addEventListener('change', toggleFsc);
    toggleFsc(); // Initial state on page load

    document.addEventListener('input', recalc);
    document.addEventListener('change', recalc);
    recalc();
});
</script>