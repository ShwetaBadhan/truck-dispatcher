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

            @php $isOwner = auth()->id() === $driver->user_id; @endphp

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    {{-- Header --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>{{ $driver->first_name }} {{ $driver->last_name }}</h3>
                            <div class="text-tiny">
                                Driver details created by {{ $driver->user?->name ?? 'Unknown' }}.
                                @if ($isOwner)
                                    <span style="color: #28a745; font-weight: bold;">This is your driver.</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            @if ($isOwner)
                                <a href="{{ route('drivers.edit', $driver->id) }}" class="tf-button" style="background: #FF5200; color: #fff; text-decoration: none;">Edit Driver</a>
                            @endif
                            <a href="{{ route('drivers.index') }}" class="tf-button" style="text-decoration: none;">Back to Driver List</a>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Driver Information --}}
                        <div class="col-md-8 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Driver Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="body-title">First Name:</div><div class="body-text">{{ $driver->first_name }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Last Name:</div><div class="body-text">{{ $driver->last_name ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Phone:</div><div class="body-text">{{ $driver->phone ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Alternate Phone:</div><div class="body-text">{{ $driver->alternate_phone ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Email:</div><div class="body-text">{{ $driver->email ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Default Payment Type:</div><div class="body-text">{{ $driver->payment_type }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Hire Date:</div><div class="body-text">{{ $driver->hire_date?->format('d-m-Y') ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Termination Date:</div><div class="body-text">{{ $driver->termination_date?->format('d-m-Y') ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Created At:</div><div class="body-text">{{ $driver->created_at->format('Y-m-d h:i:s') }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Updated At:</div><div class="body-text">{{ $driver->updated_at->format('Y-m-d h:i:s') }}</div></div>
                                </div>
                            </div>
                        </div>

                        {{-- Owner --}}
                        <div class="col-md-4 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Owner</h5>
                                <div class="body-title">Dispatcher:</div>
                                <div class="body-text mb-15">{{ $driver->user?->name ?? 'Unknown' }}</div>
                                <div class="body-title">Status:</div>
                                @if ($isOwner)
                                    <span style="background: #d1e7dd; color: #0f5132; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Your driver</span>
                                @else
                                    <span style="background: #e2e3e5; color: #41464b; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Other dispatcher</span>
                                @endif
                            </div>
                        </div>

                        {{-- License --}}
                        <div class="col-md-6 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">License</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="body-title">License Number:</div><div class="body-text">{{ $driver->license_number }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Expiration:</div><div class="body-text">{{ $driver->license_expiration?->format('d-m-Y') ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Issuing State/Jurisdiction:</div><div class="body-text">{{ $driver->license_issuing_state ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Medical Card Renewal:</div><div class="body-text">{{ $driver->medical_card_renewal?->format('d-m-Y') ?? '-' }}</div></div>
                                </div>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Address</h5>
                                <div class="row">
                                    <div class="col-12 mb-15"><div class="body-title">Street:</div><div class="body-text">{{ $driver->street ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Country:</div><div class="body-text">{{ $driver->country?->name ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">State:</div><div class="body-text">{{ $driver->state?->name ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">City:</div><div class="body-text">{{ $driver->city?->name ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Zip Code:</div><div class="body-text">{{ $driver->zip_code ?? '-' }}</div></div>
                                </div>
                            </div>
                        </div>

                        {{-- Emergency Contact --}}
                        <div class="col-12 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Emergency Contact</h5>
                                <div class="body-text">{{ $driver->emergency_contact ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection