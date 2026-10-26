@php 
    $s = $student ?? null; 
    
    // Check karein ki ye student ka khud ka profile edit hai ya admin ka edit
    $isOwnProfile = request()->routeIs('profile.edit') || (isset($isOwnProfile) && $isOwnProfile);
    
    // Sahi route select karein
    $formAction = $isOwnProfile ? route('profile.update') : ($s ? route('students.update', $s->id) : route('students.store'));
    $formMethod = $s ? 'PUT' : 'POST';
@endphp

<form action="{{ $formAction }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($formMethod === 'PUT')
        @method('PUT')
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Name <span class="tf-color-1">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $s?->name) }}" required>
            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Email <span class="tf-color-1">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $s?->email) }}" {{ $s ? 'readonly' : 'required' }}>
            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Phone <span class="tf-color-1">*</span></label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $s?->phone) }}" required>
            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Father Name</label>
            <input type="text" name="father_name" class="form-control @error('father_name') is-invalid @enderror" value="{{ old('father_name', $s?->father_name) }}">
            @error('father_name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Mother Name</label>
            <input type="text" name="mother_name" class="form-control @error('mother_name') is-invalid @enderror" value="{{ old('mother_name', $s?->mother_name) }}">
            @error('mother_name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="col-12 mb-3">
            <label class="body-title mb-10 d-block">Address</label>
            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $s?->address) }}</textarea>
            @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        {{-- Photo + Current Photo --}}
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Upload Photo (jpg, jpeg, png)</label>
            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept=".jpg,.jpeg,.png">
            @error('photo') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="col-md-6 mb-3">
            @if ($s && $s->photo_path)
                <label class="body-title mb-10 d-block">Current Photo</label>
                <div><img src="{{ asset('storage/' . $s->photo_path) }}" alt="photo" style="width:70px; height:70px; object-fit:cover; border-radius:6px;"></div>
            @endif
        </div>

        {{-- Documents --}}
        <div class="col-md-4 mb-3">
            <label class="body-title mb-10 d-block">Matric Document (PDF)</label>
            <input type="file" name="matric_pdf" class="form-control @error('matric_pdf') is-invalid @enderror" accept="application/pdf">
            @error('matric_pdf') <span class="text-danger small">{{ $message }}</span> @enderror
            @if ($s && $s->matric_pdf)
                <a href="{{ asset('storage/' . $s->matric_pdf) }}" target="_blank" class="tf-button mt-2" style="font-size:12px; padding:4px 10px; text-decoration:none;">View Current Matric PDF</a>
            @endif
        </div>
        
        <div class="col-md-4 mb-3">
            <label class="body-title mb-10 d-block">10th Document (PDF)</label>
            <input type="file" name="tenth_pdf" class="form-control @error('tenth_pdf') is-invalid @enderror" accept="application/pdf">
            @error('tenth_pdf') <span class="text-danger small">{{ $message }}</span> @enderror
            @if ($s && $s->tenth_pdf)
                <a href="{{ asset('storage/' . $s->tenth_pdf) }}" target="_blank" class="tf-button mt-2" style="font-size:12px; padding:4px 10px; text-decoration:none;">View Current 10th PDF</a>
            @endif
        </div>
        
        <div class="col-md-4 mb-3">
            <label class="body-title mb-10 d-block">Aadhaar Card (PDF)</label>
            <input type="file" name="aadhaar_pdf" class="form-control @error('aadhaar_pdf') is-invalid @enderror" accept="application/pdf">
            @error('aadhaar_pdf') <span class="text-danger small">{{ $message }}</span> @enderror
            @if ($s && $s->aadhaar_pdf)
                <a href="{{ asset('storage/' . $s->aadhaar_pdf) }}" target="_blank" class="tf-button mt-2" style="font-size:12px; padding:4px 10px; text-decoration:none;">View Current Aadhaar PDF</a>
            @endif
        </div>
    </div>

    <div class="flex items-center gap10 mt-20">
        <button type="submit" class="tf-button" style="background:#FF5200; color:#fff;">{{ $s ? 'Save Profile' : 'Register Student' }}</button>
        <a href="{{ $isOwnProfile ? route('dashboard') : route('students.index') }}" class="tf-button" style="text-decoration:none; background: #6c757d; color: #fff;">{{ $s ? 'Back to Dashboard' : 'Cancel' }}</a>
    </div>
</form>