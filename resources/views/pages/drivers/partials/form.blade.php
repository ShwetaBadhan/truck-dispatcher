@php $d = $driver ?? null; @endphp

<form action="{{ $d ? route('drivers.update', $d->id) : route('drivers.store') }}" method="POST">
    @csrf
    @if($d) @method('PUT') @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">First Name <span class="tf-color-1">*</span></label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $d?->first_name) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $d?->last_name) }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Street</label>
            <input type="text" name="street" class="form-control" value="{{ old('street', $d?->street) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Country <span class="tf-color-1">*</span></label>
            <select name="country_id" id="country_id" class="select" required>
                <option value="">Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @selected(old('country_id', $d?->country_id) == $country->id)>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">State <span class="tf-color-1">*</span></label>
            <select name="state_id" id="state_id" class="select" required>
                <option value="">Select State</option>
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" @selected(old('state_id', $d?->state_id) == $state->id)>{{ $state->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">City <span class="tf-color-1">*</span></label>
            <select name="city_id" id="city_id" class="select" required>
                <option value="">Select City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" @selected(old('city_id', $d?->city_id) == $city->id)>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Zip Code</label>
            <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code', $d?->zip_code) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $d?->phone) }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Alternate Phone</label>
            <input type="text" name="alternate_phone" class="form-control" value="{{ old('alternate_phone', $d?->alternate_phone) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $d?->email) }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Default Payment Type <span class="tf-color-1">*</span></label>
            <select name="payment_type" class="select" required>
                <option value="">Select Payment Type</option>
                @foreach ($paymentTypes as $type)
                    <option value="{{ $type }}" @selected(old('payment_type', $d?->payment_type) == $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">License Number <span class="tf-color-1">*</span></label>
            <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $d?->license_number) }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">License Expiration</label>
            <input type="date" name="license_expiration" class="form-control" value="{{ old('license_expiration', $d?->license_expiration?->format('Y-m-d')) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">License Issuing State/Jurisdiction</label>
            <input type="text" name="license_issuing_state" class="form-control" value="{{ old('license_issuing_state', $d?->license_issuing_state) }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Medical Card Renewal</label>
            <input type="date" name="medical_card_renewal" class="form-control" value="{{ old('medical_card_renewal', $d?->medical_card_renewal?->format('Y-m-d')) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Hire Date</label>
            <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', $d?->hire_date?->format('Y-m-d')) }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Termination Date</label>
            <input type="date" name="termination_date" class="form-control" value="{{ old('termination_date', $d?->termination_date?->format('Y-m-d')) }}">
        </div>

        <div class="col-12 mb-3">
            <label class="body-title mb-10 d-block">Emergency Contact</label>
            <textarea name="emergency_contact" class="form-control" rows="3">{{ old('emergency_contact', $d?->emergency_contact) }}</textarea>
        </div>
    </div>

    <div class="flex items-center gap10 mt-20">
        <button type="submit" class="tf-button" style="background: #FF5200; color: white;">
            {{ $d ? 'Update Driver' : 'Save Driver' }}
        </button>
        <a href="{{ route('drivers.index') }}" class="tf-button">Cancel</a>
    </div>
</form>