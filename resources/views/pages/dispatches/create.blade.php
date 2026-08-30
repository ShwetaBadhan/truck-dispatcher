@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ icon: 'error', title: 'Oops...', html: "{!! implode('<br>', $errors->all()) !!}" });
                    });
                </script>
            @endif

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>Add Dispatch</h3>
                            <div class="text-tiny">Build a trip with drivers, equipment, stops, and fee details from one screen.</div>
                        </div>
                        <a href="{{ route('dispatches.index') }}" class="tf-button" style="text-decoration: none;">Back to Dispatch List</a>
                    </div>

                    @include('pages.dispatches.partials.form')
                </div>
            </div>
        </div>
    </div>
@endsection