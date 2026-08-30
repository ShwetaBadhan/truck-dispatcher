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

            @php $isOwner = auth()->id() === $trailer->user_id; @endphp

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    {{-- Header --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>{{ $trailer->trailer_number }}</h3>
                            <div class="text-tiny">
                                Trailer details created by {{ $trailer->user?->name ?? 'Unknown' }}.
                                @if ($isOwner)
                                    <span style="color: #28a745; font-weight: bold;">This is your trailer.</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            @if ($isOwner)
                                <a href="{{ route('trailers.edit', $trailer->id) }}" class="tf-button" style="background: #FF5200; color: #fff; text-decoration: none;">Edit Trailer</a>
                            @endif
                            <a href="{{ route('trailers.index') }}" class="tf-button" style="text-decoration: none;">Back to Trailer List</a>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Trailer Information --}}
                        <div class="col-md-8 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Trailer Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="body-title">Trailer Number:</div><div class="body-text">{{ $trailer->trailer_number }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">VIN:</div><div class="body-text">{{ $trailer->vin ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Ownership Type:</div><div class="body-text">{{ $trailer->ownership_type }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Status:</div><div class="body-text">
                                        @if ($trailer->status)
                                            <span style="background: #d1e7dd; color: #0f5132; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Active</span>
                                        @else
                                            <span style="background: #f8d7da; color: #842029; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Inactive</span>
                                        @endif
                                    </div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Make:</div><div class="body-text">{{ $trailer->make ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Model:</div><div class="body-text">{{ $trailer->model ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Year:</div><div class="body-text">{{ $trailer->year ?? '-' }}</div></div>
                                </div>
                            </div>
                        </div>

                        {{-- Owner --}}
                        <div class="col-md-4 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Owner</h5>
                                <div class="body-title">Dispatcher:</div>
                                <div class="body-text mb-15">{{ $trailer->user?->name ?? 'Unknown' }}</div>
                                <div class="body-title">Status:</div>
                                @if ($isOwner)
                                    <span style="background: #d1e7dd; color: #0f5132; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Your trailer</span>
                                @else
                                    <span style="background: #e2e3e5; color: #41464b; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Other dispatcher</span>
                                @endif
                            </div>
                        </div>

                        {{-- Purchase --}}
                        <div class="col-md-6 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Purchase</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="body-title">Year Purchased:</div><div class="body-text">{{ $trailer->year_purchased ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Purchase Price:</div><div class="body-text">{{ $trailer->purchase_price ? '$' . number_format($trailer->purchase_price, 2) : '-' }}</div></div>
                                </div>
                            </div>
                        </div>

                        {{-- License & Expirations --}}
                        <div class="col-md-6 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">License & Expirations</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="body-title">License Plate:</div><div class="body-text">{{ $trailer->license_plate_number ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Plate Expiration:</div><div class="body-text">{{ $trailer->license_plate_expiration?->format('Y-m-d') ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Inspection Sticker Exp:</div><div class="body-text">{{ $trailer->inspection_sticker_expiration?->format('Y-m-d') ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Insurance Expiration:</div><div class="body-text">{{ $trailer->insurance_expiration?->format('Y-m-d') ?? '-' }}</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection