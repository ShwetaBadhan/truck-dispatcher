@php $s = $student ?? null; @endphp
<form action="{{ $s ? route('students.update', $s->id) : route('students.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Name <span class="tf-color-1">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $s?->name) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Email <span class="tf-color-1">*</span></label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $s?->email) }}" {{ $s ? 'readonly' : 'required' }}>
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Phone <span class="tf-color-1">*</span></label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $s?->phone) }}" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Father Name</label>
            <input type="text" name="father_name" class="form-control" value="{{ old('father_name', $s?->father_name) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Mother Name</label>
            <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name', $s?->mother_name) }}">
        </div>

        <div class="col-12 mb-3">
            <label class="body-title mb-10 d-block">Address</label>
            <textarea name="address" class="form-control" rows="3">{{ old('address', $s?->address) }}</textarea>
        </div>

        {{-- Photo + Current Photo --}}
        <div class="col-md-6 mb-3">
            <label class="body-title mb-10 d-block">Upload Photo (jpg, jpeg, png)</label>
            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png">
        </div>
        <div class="col-md-6 mb-3">
            @if ($s && $s->photo_path)
                <label class="body-title mb-10 d-block">Current Photo</label>
                <div><img src="{{ $s->photo_url }}" alt="photo" style="width:70px; height:70px; object-fit:cover; border-radius:6px;"></div>
            @endif
        </div>

        {{-- Documents --}}
        <div class="col-md-4 mb-3">
            <label class="body-title mb-10 d-block">Matric Document (PDF)</label>
            <input type="file" name="matric_pdf" class="form-control" accept="application/pdf">
            @if ($s && $s->matric_pdf)
                <a href="{{ $s->matric_pdf_url }}" target="_blank" class="tf-button mt-2" style="font-size:12px; padding:4px 10px; text-decoration:none;">View Current Matric PDF</a>
            @endif
        </div>
        <div class="col-md-4 mb-3">
            <label class="body-title mb-10 d-block">10th Document (PDF)</label>
            <input type="file" name="tenth_pdf" class="form-control" accept="application/pdf">
            @if ($s && $s->tenth_pdf)
                <a href="{{ $s->tenth_pdf_url }}" target="_blank" class="tf-button mt-2" style="font-size:12px; padding:4px 10px; text-decoration:none;">View Current 10th PDF</a>
            @endif
        </div>
        <div class="col-md-4 mb-3">
            <label class="body-title mb-10 d-block">Aadhaar Card (PDF)</label>
            <input type="file" name="aadhaar_pdf" class="form-control" accept="application/pdf">
            @if ($s && $s->aadhaar_pdf)
                <a href="{{ $s->aadhaar_pdf_url }}" target="_blank" class="tf-button mt-2" style="font-size:12px; padding:4px 10px; text-decoration:none;">View Current Aadhaar PDF</a>
            @endif
        </div>

       
        
    </div>

    <div class="flex items-center gap10 mt-20">
        <button type="submit" class="tf-button" style="background:#FF5200; color:#fff;">{{ $s ? 'Save Profile' : 'Register Student' }}</button>
        <a href="{{ $s ? route('dashboard') : route('students.index') }}" class="tf-button" style="text-decoration:none;">{{ $s ? 'Back to Dashboard' : 'Cancel' }}</a>
    </div>
</form>