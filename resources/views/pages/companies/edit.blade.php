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
                            <h3>Edit Company</h3>
                            <div class="text-tiny">Update company: <strong>{{ $company->name }}</strong></div>
                        </div>
                        <div class="flex items-center gap10">
                            <a href="{{ route('companies.show', $company->id) }}" class="tf-button" style="text-decoration: none;">View Details</a>
                            <a href="{{ route('companies.index') }}" class="tf-button" style="text-decoration: none;">Back to Company List</a>
                        </div>
                    </div>

                    <div class="wg-box p-20">
                        <form action="{{ route('companies.update', $company->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Company Name <span class="tf-color-1">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Street</label>
                                    <input type="text" name="street" class="form-control" value="{{ old('street', $company->street) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Apt/Suite/Other</label>
                                    <input type="text" name="apt_suite_other" class="form-control" value="{{ old('apt_suite_other', $company->apt_suite_other) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Country <span class="tf-color-1">*</span></label>
                                    <select name="country_id" id="country_id" class="select" required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @selected(old('country_id', $company->country_id) == $country->id)>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">State <span class="tf-color-1">*</span></label>
                                    <select name="state_id" id="state_id" class="select" required>
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}" @selected(old('state_id', $company->state_id) == $state->id)>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">City <span class="tf-color-1">*</span></label>
                                    <select name="city_id" id="city_id" class="select" required>
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @selected(old('city_id', $company->city_id) == $city->id)>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Zip Code</label>
                                    <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code', $company->zip_code) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $company->phone_number) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Alternate Phone</label>
                                    <input type="text" name="alternate_phone" class="form-control" value="{{ old('alternate_phone', $company->alternate_phone) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $company->email) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Website</label>
                                    <input type="text" name="website" class="form-control" value="{{ old('website', $company->website) }}" placeholder="https://example.com">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Motor Carrier Number</label>
                                    <input type="text" name="motor_carrier_number" class="form-control" value="{{ old('motor_carrier_number', $company->motor_carrier_number) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Tax ID (EIN#)</label>
                                    <input type="text" name="tax_id" class="form-control" value="{{ old('tax_id', $company->tax_id) }}">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="body-title mb-10 d-block">Notes</label>
                                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $company->notes) }}</textarea>
                                </div>
                            </div>

                            <div class="flex items-center gap10 mt-20">
                                <button type="submit" class="tf-button" style="background: #FF5200; color: white;">Update Company</button>
                                <a href="{{ route('companies.index') }}" class="tf-button" style="background: #6c757d; color: white; text-decoration: none;">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Cascading Country -> State -> City --}}
            @include('pages.drivers.partials.location-script')
        </div>
    </div>
@endsection