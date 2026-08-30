@extends('layout.master')

@section('content')
<div class="section-content-right">
    <div class="main-content">
        @if (session('success'))
            <script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'success', title: 'Done!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false }); });</script>
        @endif
        @if ($errors->any())
            <script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'error', title: 'Oops...', html: "{!! implode('<br>', $errors->all()) !!}" }); });</script>
        @endif

        <div class="main-content-inner">
            <div class="main-content-wrap">

                <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                    <div>
                        <h3>Edit Profile</h3>
                        <div class="text-tiny">Keep your training profile, documents, and photo up to date.</div>
                    </div>
                    <a href="{{ route('dashboard') }}" class="tf-button" style="text-decoration:none;">Back to Dashboard</a>
                </div>

                <div class="wg-box p-20">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="body-title mb-10 d-block">Name <span class="tf-color-1">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="body-title mb-10 d-block">Email (Login)</label>
                                <input type="email" class="form-control" value="{{ $student->email }}" readonly style="background:#f3f4f6;">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="body-title mb-10 d-block">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="body-title mb-10 d-block">Father Name</label>
                                <input type="text" name="father_name" class="form-control" value="{{ old('father_name', $student->father_name) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="body-title mb-10 d-block">Mother Name</label>
                                <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name', $student->mother_name) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="body-title mb-10 d-block">Batch</label>
                                <input type="text" class="form-control" value="{{ $student->batch?->name ?? 'Not Assigned' }}" readonly style="background:#f3f4f6;">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="body-title mb-10 d-block">Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $student->address) }}</textarea>
                            </div>

                            {{-- Photo --}}
                            <div class="col-md-6 mb-3">
                                <label class="body-title mb-10 d-block">Upload Photo (jpg, jpeg, png)</label>
                                <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png">
                            </div>
                            <div class="col-md-6 mb-3">
                                @if ($student->photo_path)
                                    <label class="body-title mb-10 d-block">Current Photo</label>
                                    <img src="{{ $student->photo_url }}" alt="photo" style="width:70px; height:70px; object-fit:cover; border-radius:8px;">
                                @endif
                            </div>

                            {{-- Documents --}}
                            <div class="col-md-4 mb-3">
                                <label class="body-title mb-10 d-block">Matric Document (PDF)</label>
                                <input type="file" name="matric_pdf" class="form-control" accept="application/pdf">
                                @if ($student->matric_pdf)
                                    <a href="{{ $student->matric_pdf_url }}" target="_blank" class="text-tiny" style="color:#5a5bd8;">View Current Matric PDF</a>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="body-title mb-10 d-block">10th Document (PDF)</label>
                                <input type="file" name="tenth_pdf" class="form-control" accept="application/pdf">
                                @if ($student->tenth_pdf)
                                    <a href="{{ $student->tenth_pdf_url }}" target="_blank" class="text-tiny" style="color:#5a5bd8;">View Current 10th PDF</a>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="body-title mb-10 d-block">Aadhaar Card (PDF)</label>
                                <input type="file" name="aadhaar_pdf" class="form-control" accept="application/pdf">
                                @if ($student->aadhaar_pdf)
                                    <a href="{{ $student->aadhaar_pdf_url }}" target="_blank" class="text-tiny" style="color:#5a5bd8;">View Current Aadhaar PDF</a>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap10 mt-20">
                            <button type="submit" class="tf-button" style="background:#FF5200; color:#fff;">Save Profile</button>
                            <a href="{{ route('dashboard') }}" class="tf-button" style="text-decoration:none;">Cancel</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection