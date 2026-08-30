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

            @php $isOwner = auth()->id() === $company->user_id; @endphp

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    {{-- Header --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>{{ $company->name }}</h3>
                            <div class="text-tiny">
                                Company details created by {{ $company->user?->name ?? 'Unknown' }}.
                                @if ($isOwner)
                                    <span style="color: #28a745; font-weight: bold;">This is your company.</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap10">
                            @if ($isOwner)
                                <a href="{{ route('companies.edit', $company->id) }}" class="tf-button" style="background: #FF5200; color: #fff; text-decoration: none;">Edit Company</a>
                            @endif
                            <a href="{{ route('companies.index') }}" class="tf-button" style="text-decoration: none;">Back to Company List</a>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Company Information --}}
                        <div class="col-md-8 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Company Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-15"><div class="body-title">Company Name:</div><div class="body-text">{{ $company->name }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Motor Carrier Number:</div><div class="body-text">{{ $company->motor_carrier_number ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Phone Number:</div><div class="body-text">{{ $company->phone_number ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Alternate Phone:</div><div class="body-text">{{ $company->alternate_phone ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Email:</div><div class="body-text">{{ $company->email ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Website:</div><div class="body-text">{{ $company->website ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Tax ID (EIN#):</div><div class="body-text">{{ $company->tax_id ?? '-' }}</div></div>
                                </div>
                            </div>
                        </div>

                        {{-- Owner --}}
                        <div class="col-md-4 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Owner</h5>
                                <div class="body-title">Dispatcher:</div>
                                <div class="body-text mb-15">{{ $company->user?->name ?? 'Unknown' }}</div>
                                <div class="body-title">Status:</div>
                                @if ($isOwner)
                                    <span style="background: #d1e7dd; color: #0f5132; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Your company</span>
                                @else
                                    <span style="background: #e2e3e5; color: #41464b; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Other dispatcher</span>
                                @endif
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Address</h5>
                                <div class="row">
                                    <div class="col-12 mb-15"><div class="body-title">Street:</div><div class="body-text">{{ $company->street ?? '-' }} {{ $company->apt_suite_other ? ', ' . $company->apt_suite_other : '' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Country:</div><div class="body-text">{{ $company->country?->name ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">State:</div><div class="body-text">{{ $company->state?->name ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">City:</div><div class="body-text">{{ $company->city?->name ?? '-' }}</div></div>
                                    <div class="col-md-6 mb-15"><div class="body-title">Zip Code:</div><div class="body-text">{{ $company->zip_code ?? '-' }}</div></div>
                                </div>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="col-md-6 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Notes</h5>
                                <div class="body-text">{{ $company->notes ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection