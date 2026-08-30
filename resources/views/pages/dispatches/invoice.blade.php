<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dispatch Invoice - {{ $dispatch->trip_name }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; background: #f8f9fa; margin: 0; padding: 25px; color: #111; }
        .no-print { margin-bottom: 20px; }
        .no-print button { padding: 6px 16px; cursor: pointer; border: 1px solid #999; background: #fff; border-radius: 3px; }
        h1 { margin: 0 0 5px; font-size: 26px; }
        h3 { margin: 20px 0 10px; font-size: 16px; }
        .muted { color: #555; font-size: 13px; }
        .head { display: flex; justify-content: space-between; align-items: flex-start; }
        .right { text-align: right; font-size: 13px; }
        .labels { text-transform: uppercase; font-size: 10px; color: #777; letter-spacing: .5px; margin-bottom: 3px; }
        .grid { display: flex; gap: 60px; margin: 22px 0; flex-wrap: wrap; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; }
        th { background: #f0f0f0; }
        .summary { margin-top: 25px; }
        .summary td:last-child { text-align: right; font-weight: bold; }
        .total td { font-weight: bold; font-size: 15px; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; background: #fff; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()">Print</button>
    </div>

    {{-- Header --}}
    <div class="head">
        <div>
            <h1>Dispatch Invoice</h1>
            <div class="muted">Trip: {{ $dispatch->trip_name }}</div>
        </div>
        <div class="right">
            <strong>Dispatcher: {{ $dispatch->user?->name ?? 'Unknown' }}</strong><br>
            <strong>Date: {{ now()->format('M d, Y') }}</strong>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="grid">
        <div>
            <div class="labels">Customer</div>
            <div>{{ $dispatch->customer?->name ?? '-' }}</div>
        </div>
        <div>
            <div class="labels">Driver</div>
            <div>{{ $dispatch->driver?->first_name }} {{ $dispatch->driver?->last_name }}</div>
        </div>
    </div>
    <div class="grid" style="margin-top: -5px;">
        <div>
            <div class="labels">Truck / Trailer</div>
            <div>{{ $dispatch->truck?->unit_number ?? '-' }} / {{ $dispatch->trailer?->trailer_number ?? '-' }}</div>
        </div>
        <div>
            <div class="labels">Miles</div>
            <div>Loaded {{ number_format((float) $dispatch->loaded_miles, 2) }}, Deadhead {{ number_format((float) $dispatch->deadhead_miles, 2) }}, Total {{ number_format((float) $dispatch->total_miles, 2) }}</div>
        </div>
    </div>

    {{-- Pickups --}}
    <h3>Pickups</h3>
    <table>
        <thead>
            <tr><th>Shipper</th><th>Address</th><th>Date</th><th>Weight</th><th>Quantity</th><th>Type</th></tr>
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
                <tr><td colspan="6">No pickups added.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Deliveries --}}
    <h3>Deliveries</h3>
    <table>
        <thead>
            <tr><th>Consignee</th><th>Address</th><th>Date</th><th>Instructions</th></tr>
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
                <tr><td colspan="4">No deliveries added.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- Summary --}}
    <table class="summary">
        <tr><td>Primary Charges</td><td>${{ number_format((float) $dispatch->primary_charges, 2) }}</td></tr>
        <tr><td>Fuel Surcharge</td><td>${{ number_format((float) $dispatch->fuel_surcharge, 2) }}</td></tr>
        <tr><td>Accessory Fees</td><td>${{ number_format((float) $dispatch->accessory_fees, 2) }}</td></tr>
        <tr><td>Invoice Advance</td><td>${{ number_format((float) $dispatch->invoice_advance, 2) }}</td></tr>
        <tr class="total"><td>Invoice Total</td><td>${{ number_format((float) $dispatch->invoice_total, 2) }}</td></tr>
    </table>
</body>
</html>