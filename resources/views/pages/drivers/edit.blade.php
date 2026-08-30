@extends('layout.master')

@section('content')
<div class="section-content-right">
    <div class="main-content">
        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                    <div>
                        <h3>Edit Driver</h3>
                        <div class="text-tiny">Update driver profile: {{ $driver->first_name }} {{ $driver->last_name }}</div>
                    </div>
                    <a href="{{ route('drivers.index') }}" class="tf-button">Back to Driver List</a>
                </div>

                <div class="wg-box p-20">
                    @include('pages.drivers.partials.form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('pages.drivers.partials.location-script')
@endpush