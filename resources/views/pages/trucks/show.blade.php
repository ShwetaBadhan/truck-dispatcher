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
                $isOwner = auth()->id() === $truck->user_id;
                $badge = match($truck->status) {
                    'Available' => 'background:#d1e7dd; color:#0f5132;',
                    'In Service' => 'background:#cfe2ff; color:#084298;',
                    default => 'background:#f8d7da; color:#842029;',
                };
            @endphp

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    {{-- Header --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>{{ $truck->unit_number }}</h3>
                            <div class="text-tiny">
                                Truck details created by {{ $truck->user?->name ?? 'Unknown' }}.
                                @if ($isOwner)
                                    <span style="color: #28a745; font-weight: bold;">This is your truck.</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            @if ($isOwner)
                                <a href="{{ route('trucks.edit', $truck->id) }}" class="tf-button" style="background: #FF5200; color: #fff; text-decoration: none;">Edit Truck</a>
                            @endif
                            <a href="{{ route('trucks.index') }}" class="tf-button" style="text-decoration: none;">Back to Truck List</a>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Truck Information --}}
                        <div class="col-md-8 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Truck Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="body-title">Unit Number:</div><div class="body-text">{{ $truck->unit_number }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Status:</div><div class="body-text"><span style="{{ $badge }} padding: 4px 10px; border-radius: 4px; font-size: 12px;">{{ $truck->status }}</span></div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">VIN:</div><div class="body-text">{{ $truck->vin ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Capacity:</div><div class="body-text">{{ number_format($truck->capacity_lbs) }} lbs</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Created At:</div><div class="body-text">{{ $truck->created_at->format('Y-m-d h:i:s') }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Updated At:</div><div class="body-text">{{ $truck->updated_at->format('Y-m-d h:i:s') }}</div></div>
                                </div>
                            </div>
                        </div>

                        {{-- Owner --}}
                        <div class="col-md-4 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Owner</h5>
                                <div class="body-title">Dispatcher:</div>
                                <div class="body-text mb-15">{{ $truck->user?->name ?? 'Unknown' }}</div>
                                <div class="body-title">Status:</div>
                                @if ($isOwner)
                                    <span style="background: #d1e7dd; color: #0f5132; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Your truck</span>
                                @else
                                    <span style="background: #e2e3e5; color: #41464b; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Other dispatcher</span>
                                @endif
                            </div>
                        </div>

                        {{-- Vehicle Details --}}
                        <div class="col-md-6 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Vehicle</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="body-title">Make:</div><div class="body-text">{{ $truck->make ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Model:</div><div class="body-text">{{ $truck->model ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Year:</div><div class="body-text">{{ $truck->year ?? '-' }}</div></div>
                                </div>
                            </div>
                        </div>

                        {{-- Plate Details --}}
                        <div class="col-md-6 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Plate</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="body-title">Plate Number:</div><div class="body-text">{{ $truck->plate_number ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Plate State:</div><div class="body-text">{{ $truck->plate_state ?? '-' }}</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection