@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ icon: 'success', title: 'Done!', text: "{{ session('success') }}", timer: 2500, timerProgressBar: true, showConfirmButton: false });
                    });
                </script>
            @endif

            @php
                $isOwner = auth()->id() === $dispatch->user_id;
                $accessoryWithData = collect(\App\Models\Dispatch::ACCESSORY_FEES)->filter(fn($label, $field) => (float) $dispatch->$field > 0);
            @endphp

            <style>
                .inv-table { width: 100%; border-collapse: collapse; font-size: 13px; }
                .inv-table th { text-align: left; padding: 8px; border-bottom: 2px solid #eee; text-transform: uppercase; font-size: 11px; color: #555; }
                .inv-table td { padding: 10px 8px; border-bottom: 1px solid #f2f2f2; }
            </style>

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    {{-- Header --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>Dispatch Invoice</h3>
                            <div class="text-tiny">
                                Invoice preview for {{ $dispatch->trip_name }} created by {{ $dispatch->user?->name ?? 'Unknown' }}.
                                @if ($isOwner)
                                    <span style="color: #28a745; font-weight: bold;">This is your dispatch.</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            <a href="{{ route('dispatches.index') }}" class="tf-button" style="text-decoration: none;">Back to Dispatches</a>
                            @if ($isOwner)
                                <a href="{{ route('dispatches.edit', $dispatch->id) }}" class="tf-button" style="text-decoration: none;">Edit Dispatch</a>
                            @endif
                            <a href="{{ route('dispatches.invoice', $dispatch->id) }}" target="_blank" class="tf-button" style="background: #FF5200; color: #fff; text-decoration: none;">Print Invoice</a>
                        </div>
                    </div>

                    <div class="row">
                        {{-- ================= LEFT COLUMN ================= --}}
                        <div class="col-md-8">
                            {{-- Trip Info --}}
                            <div class="wg-box p-20 mb-20">
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="text-tiny mb-5">Trip Name</div><div class="body-text">{{ $dispatch->trip_name }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="text-tiny mb-5">Customer</div><div class="body-text">{{ $dispatch->customer?->name ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="text-tiny mb-5">Owner</div><div class="body-text">{{ $dispatch->user?->name ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="text-tiny mb-5">Driver</div><div class="body-text">{{ $dispatch->driver?->first_name }} {{ $dispatch->driver?->last_name }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="text-tiny mb-5">Truck / Trailer</div><div class="body-text">{{ $dispatch->truck?->unit_number ?? '-' }} / {{ $dispatch->trailer?->trailer_number ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="text-tiny mb-5">Loaded Miles</div><div class="body-text">{{ number_format((float) $dispatch->loaded_miles, 2) }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="text-tiny mb-5">Deadhead Miles</div><div class="body-text">{{ number_format((float) $dispatch->deadhead_miles, 2) }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="text-tiny mb-5">Total Miles</div><div class="body-text">{{ number_format((float) $dispatch->total_miles, 2) }}</div></div>
                                </div>
                            </div>

                            {{-- Pickups --}}
                            <div class="wg-box p-20 mb-20">
                                <h5 class="mb-15">Pickups</h5>
                                <table class="inv-table">
                                    <thead>
                                        <tr>
                                            <th>Shipper</th><th>Address</th><th>Date</th><th>Weight</th><th>Quantity</th><th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dispatch->pickups as $p)
                                            <tr>
                                                <td>{{ $p->shipper?->name ?? '-' }}</td>
                                                <td>{{ $p->street ? $p->street . ', ' : '' }}{{ $p->city?->name ?? '' }}, {{ $p->state?->name ?? '' }}, {{ $p->country?->name ?? '' }}</td>
                                                <td>{{ $p->pickup_date?->format('M d, Y') ?? '-' }}</td>
                                                <td>{{ number_format((float) $p->weight, 2) }}</td>
                                                <td>{{ $p->quantity ?? '-' }}</td>
                                                <td>{{ $p->type ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="6" class="text-tiny">No pickups added.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Deliveries --}}
                            <div class="wg-box p-20 mb-20">
                                <h5 class="mb-15">Deliveries</h5>
                                <table class="inv-table">
                                    <thead>
                                        <tr>
                                            <th>Consignee</th><th>Address</th><th>Date</th><th>Instructions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dispatch->deliveries as $del)
                                            <tr>
                                                <td>{{ $del->consignee?->name ?? '-' }}</td>
                                                <td>{{ $del->street ? $del->street . ', ' : '' }}{{ $del->city?->name ?? '' }}, {{ $del->state?->name ?? '' }}, {{ $del->country?->name ?? '' }}</td>
                                                <td>{{ $del->delivery_date?->format('M d, Y') ?? '-' }}</td>
                                                <td>{{ $del->instructions ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-tiny">No deliveries added.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ================= RIGHT COLUMN ================= --}}
                        <div class="col-md-4">
                            {{-- Invoice Summary --}}
                            <div class="wg-box p-20 mb-20">
                                <h5 class="mb-15">Invoice Summary</h5>
                                <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee;"><span>Primary Charges</span><strong>${{ number_format((float) $dispatch->primary_charges, 2) }}</strong></div>
                                <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee;"><span>Fuel Surcharge</span><strong>${{ number_format((float) $dispatch->fuel_surcharge, 2) }}</strong></div>
                                <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee;"><span>Accessory Fees</span><strong>${{ number_format((float) $dispatch->accessory_fees, 2) }}</strong></div>
                                <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee;"><span>Invoice Advance</span><strong>${{ number_format((float) $dispatch->invoice_advance, 2) }}</strong></div>
                                <div style="display:flex; justify-content:space-between; padding:12px 0 0;"><span style="font-size:16px;"><strong>Invoice Total</strong></span><strong style="font-size:18px;">${{ number_format((float) $dispatch->invoice_total, 2) }}</strong></div>
                            </div>

                            {{-- Accessory Fees --}}
                            <div class="wg-box p-20 mb-20">
                                <h5 class="mb-15">Accessory Fees</h5>
                                @forelse ($accessoryWithData as $field => $label)
                                    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #eee;">
                                        <span>{{ $label }}</span><strong>${{ number_format((float) $dispatch->$field, 2) }}</strong>
                                    </div>
                                @empty
                                    <div class="text-tiny">No accessory fees added.</div>
                                @endforelse
                            </div>

                            {{-- Team Members --}}
                            <div class="wg-box p-20 mb-20">
                                <h5 class="mb-15">Team Members</h5>
                                @forelse ($dispatch->teamMembers as $member)
                                    <div style="padding:8px 0; border-bottom:1px solid #eee;">
                                        <div class="body-text" style="font-weight:bold;">{{ $member->driver?->first_name }} {{ $member->driver?->last_name }}</div>
                                        <div class="text-tiny">Accessory Pay: ${{ number_format((float) $member->accessory_driver_pay, 2) }} | Advance: ${{ number_format((float) $member->driver_advance, 2) }}</div>
                                    </div>
                                @empty
                                    <div class="text-tiny">No team members added.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection