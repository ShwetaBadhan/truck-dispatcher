@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            {{-- Validation Errors (Swal) --}}
            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ icon: 'error', title: 'Oops...', html: "{!! implode('<br>', $errors->all()) !!}" });
                    });
                </script>
            @endif

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    {{-- Header --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>Edit Dispatch</h3>
                            <div class="text-tiny">Update trip: <strong>{{ $dispatch->trip_name }}</strong></div>
                        </div>
                        <div class="flex items-center gap10">
                            <a href="{{ route('dispatches.show', $dispatch->id) }}" class="tf-button" style="text-decoration: none;">View
                                Details</a>
                            <a href="{{ route('dispatches.index') }}" class="tf-button" style="text-decoration: none;">Back to Dispatch
                                List</a>
                        </div>
                    </div>

                    {{-- Shared Form (team, pickups, deliveries, fees, invoice summary) --}}
                    @include('pages.dispatches.partials.form')
                </div>
            </div>
        </div>
    </div>
@endsection