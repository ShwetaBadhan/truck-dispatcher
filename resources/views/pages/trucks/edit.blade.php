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
                            <h3>Edit Truck</h3>
                            <div class="text-tiny">Update truck unit: <strong>{{ $truck->unit_number }}</strong></div>
                        </div>
                        <div class="flex items-center gap10">
                            <a href="{{ route('trucks.show', $truck->id) }}" class="tf-button" style="text-decoration: none;">View Details</a>
                            <a href="{{ route('trucks.index') }}" class="tf-button" style="text-decoration: none;">Back to Truck List</a>
                        </div>
                    </div>

                    {{-- Form --}}
                    <div class="wg-box p-20">
                        <form action="{{ route('trucks.update', $truck->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Unit Number <span class="tf-color-1">*</span></label>
                                    <input type="text" name="unit_number" class="form-control" value="{{ old('unit_number', $truck->unit_number) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Status <span class="tf-color-1">*</span></label>
                                    <select name="status" class="select" required>
                                        <option value="">Select Status</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" @selected(old('status', $truck->status) == $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">VIN</label>
                                    <input type="text" name="vin" class="form-control" value="{{ old('vin', $truck->vin) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Make</label>
                                    <input type="text" name="make" class="form-control" value="{{ old('make', $truck->make) }}" placeholder="e.g. Freightliner">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Plate Number</label>
                                    <input type="text" name="plate_number" class="form-control" value="{{ old('plate_number', $truck->plate_number) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Plate State</label>
                                    <input type="text" name="plate_state" class="form-control" value="{{ old('plate_state', $truck->plate_state) }}" placeholder="e.g. California">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Model</label>
                                    <input type="text" name="model" class="form-control" value="{{ old('model', $truck->model) }}" placeholder="e.g. Cascadia">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="body-title mb-10 d-block">Year</label>
                                    <input type="number" name="year" class="form-control" value="{{ old('year', $truck->year) }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="body-title mb-10 d-block">Capacity (lbs)</label>
                                    <input type="number" name="capacity_lbs" class="form-control" value="{{ old('capacity_lbs', $truck->capacity_lbs) }}">
                                </div>
                            </div>

                            <div class="flex items-center gap10 mt-20">
                                <button type="submit" class="tf-button" style="background: #FF5200; color: white;">Update Truck</button>
                                <a href="{{ route('trucks.index') }}" class="tf-button" style="background: #6c757d; color: white; text-decoration: none;">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection