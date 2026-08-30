@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            @if ($errors->any())
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: "{!! implode('<br>', $errors->all()) !!}"
                        });
                    });
                </script>
            @endif

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>Add Trailer</h3>
                            <div class="text-tiny">Save a trailer profile for dispatcher training.</div>
                        </div>
                        <a href="{{ route('trailers.index') }}" class="tf-button" style="text-decoration: none;">Back to
                            Trailer List</a>
                    </div>

                    <div class="wg-box p-20">
                        <form action="{{ route('trailers.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Trailer Number <span
                                            class="tf-color-1">*</span></label>
                                    <input type="text" name="trailer_number" class="form-control"
                                        value="{{ old('trailer_number') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Ownership Type <span
                                            class="tf-color-1">*</span></label>
                                    <select name="ownership_type" class="select" required>
                                        <option value="">Select Ownership Type</option>
                                        @foreach ($ownershipTypes as $type)
                                            <option value="{{ $type }}" @selected(old('ownership_type') == $type)>
                                                {{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">VIN</label>
                                    <input type="text" name="vin" class="form-control" value="{{ old('vin') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Status <span class="tf-color-1">*</span></label>
                                    <select name="status" class="select" required>
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    
                                   
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">Make</label>
                                    <input type="text" name="make" class="form-control" value="{{ old('make') }}"
                                        placeholder="e.g. Hyundai">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">Model</label>
                                    <input type="text" name="model" class="form-control" value="{{ old('model') }}"
                                        placeholder="e.g. 3000R">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">Year</label>
                                    <input type="number" name="year" class="form-control" value="{{ old('year') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Year Purchased</label>
                                    <input type="number" name="year_purchased" class="form-control"
                                        value="{{ old('year_purchased') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Purchase Price</label>
                                    <input type="number" step="0.01" name="purchase_price" class="form-control"
                                        value="{{ old('purchase_price') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">License Plate Number</label>
                                    <input type="text" name="license_plate_number" class="form-control"
                                        value="{{ old('license_plate_number') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">License Plate Expiration</label>
                                    <input type="date" name="license_plate_expiration" class="form-control"
                                        value="{{ old('license_plate_expiration') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Inspection Sticker Expiration</label>
                                    <input type="date" name="inspection_sticker_expiration" class="form-control"
                                        value="{{ old('inspection_sticker_expiration') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Insurance Expiration</label>
                                    <input type="date" name="insurance_expiration" class="form-control"
                                        value="{{ old('insurance_expiration') }}">
                                </div>
                            </div>

                            <div class="flex items-center gap10 mt-20">
                                <button type="submit" class="tf-button" style="background: #FF5200; color: white;">Save
                                    Trailer</button>
                                <a href="{{ route('trailers.index') }}" class="tf-button"
                                    style="background: #6c757d; color: white; text-decoration: none;">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
