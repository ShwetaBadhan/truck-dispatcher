@extends('layout.master')

@section('content')
<div class="section-content-right">
    <div class="main-content">
        @if (session('success'))
            <script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'success', title: 'Done!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false }); });</script>
        @endif

        <div class="main-content-inner">
            <div class="main-content-wrap">

                {{-- ========== WELCOME BANNER ========== --}}
                <div class="wg-box p-20 mb-20" style="background:linear-gradient(120deg, #1f2937 0%, #FF5200 100%); border-radius:12px; color:#fff;">
                    <div class="flex items-center justify-between flex-wrap gap20">
                        <div>
                            <div class="text-tiny" style="color:rgba(255,255,255,.7); letter-spacing:1px;">STUDENT TRAINING WORKSPACE</div>
                            <h3 style="color:#fff; margin:6px 0;">Welcome back, {{ auth()->user()->name }} 👋</h3>
                            <div style="color:rgba(255,255,255,.85); max-width:640px;">
                                Here, you can view your batch's daily lectures, syllabus topics, and training documents.
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="tf-button" style="background:#FFB020; color:#111; font-weight:bold; text-decoration:none;">Edit Profile</a>
                    </div>
                </div>

                @if (!$student || !$student->batch_id)
                    {{-- No batch assigned --}}
                    <div class="wg-box p-40 mb-30" style="background:#fff3cd; color:#856404; border-left:4px solid #ffc107;">
                       <strong>No Batch Assigned!</strong> Your student profile has been created, but no batch has been assigned yet.
                        Please contact the admin/teacher to access your daily lectures.
                    </div>
                @else

                <div class="row">
                    {{-- ========== PROFILE OVERVIEW ========== --}}
                    <div class="col-md-8 mb-20">
                        <div class="wg-box p-20">
                            <h5 class="mb-20">Profile Overview</h5>
                            <div class="row">
                                <div class="col-md-6 mb-15"><div class="body-title">Name:</div><div class="body-text">{{ $student->name }}</div></div>
                                <div class="col-md-6 mb-15"><div class="body-title">Phone:</div><div class="body-text">{{ $student->phone ?? '-' }}</div></div>
                                <div class="col-md-6 mb-15"><div class="body-title">Email:</div><div class="body-text">{{ $student->email }}</div></div>
                                <div class="col-md-6 mb-15"><div class="body-title">Joining Date:</div><div class="body-text">{{ $student->created_at?->format('M d, Y') }}</div></div>
                                <div class="col-md-6 mb-15"><div class="body-title">Father Name:</div><div class="body-text">{{ $student->father_name ?? '-' }}</div></div>
                                <div class="col-md-6 mb-15"><div class="body-title">Mother Name:</div><div class="body-text">{{ $student->mother_name ?? '-' }}</div></div>
                                <div class="col-md-6 mb-15">
                                    <div class="body-title">Batch:</div>
                                    <div class="body-text"><span style="background:#d1e7dd; color:#0f5132; padding:4px 10px; border-radius:4px; font-size:12px;">{{ $student->batch->name }}</span></div>
                                </div>
                                <div class="col-md-6 mb-15"><div class="body-title">Total Lectures:</div><div class="body-text">{{ $lectureCount }}</div></div>
                                <div class="col-12 mb-15"><div class="body-title">Address:</div><div class="body-text">{{ $student->address ?? '-' }}</div></div>
                            </div>
                        </div>
                    </div>

                    {{-- ========== DOCUMENTS ========== --}}
                    <div class="col-md-4 mb-20">
                        <div class="wg-box p-20">
                            <h5 class="mb-20">Documents</h5>

                            @if ($student->photo_path)
                                <div class="mb-15 text-center">
                                    <img src="{{ $student->photo_url }}" alt="photo" style="width:80px; height:80px; object-fit:cover; border-radius:50%;">
                                </div>
                            @endif

                            <div class="mb-10">
                                @if ($student->matric_pdf)
                                    <a href="{{ $student->matric_pdf_url }}" target="_blank" class="tf-button" style="width:100%; justify-content:center; text-decoration:none;">Matric PDF</a>
                                @else
                                    <span class="tf-button" style="width:100%; justify-content:center; opacity:.5;">Matric PDF (Not Uploaded)</span>
                                @endif
                            </div>
                            <div class="mb-10">
                                @if ($student->tenth_pdf)
                                    <a href="{{ $student->tenth_pdf_url }}" target="_blank" class="tf-button" style="width:100%; justify-content:center; text-decoration:none;">10th PDF</a>
                                @else
                                    <span class="tf-button" style="width:100%; justify-content:center; opacity:.5;">10th PDF (Not Uploaded)</span>
                                @endif
                            </div>
                            <div class="mb-15">
                                @if ($student->aadhaar_pdf)
                                    <a href="{{ $student->aadhaar_pdf_url }}" target="_blank" class="tf-button" style="width:100%; justify-content:center; text-decoration:none;">Aadhaar PDF</a>
                                @else
                                    <span class="tf-button" style="width:100%; justify-content:center; opacity:.5;">Aadhaar PDF (Not Uploaded)</span>
                                @endif
                            </div>

                            <a href="{{ route('profile.edit') }}" class="tf-button" style="background:#FFB020; color:#111; font-weight:bold; text-decoration:none;">Edit Profile</a>
                        </div>
                    </div>
                </div>

                {{-- ========== TRAINING MODULES ========== --}}
                <div class="wg-box p-20 mb-20">
                    <h5 class="mb-20">Training Modules</h5>
                    <div class="row">
                        <div class="col-md-6 mb-15">
                            <a href="{{ route('syllabuses.index') }}" style="border:1px solid #5a5bd8; border-radius:8px; padding:15px; display:block; text-decoration:none;">
                                <div style="color:#5a5bd8; font-weight:bold;">Syllabus</div>
                                <div class="text-tiny" style="color:#6b7280;">View topics and available PDFs</div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-15">
                            <a href="{{ route('lectures.index') }}" style="border:1px solid #5a5bd8; border-radius:8px; padding:15px; display:block; text-decoration:none;">
                                <div style="color:#5a5bd8; font-weight:bold;">Daily Lectures</div>
                                <div class="text-tiny" style="color:#6b7280;">Open lectures shared for your batch</div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ========== ONLINE CLASSES ========== --}}
                <div class="wg-box p-20 mb-20">
                    <div class="flex items-center justify-between mb-15">
                        <h5 style="margin:0;">Online Classes</h5>
                        <span class="text-tiny">{{ $student->batch ? 1 : 0 }} links available</span>
                    </div>
                    <div style="border:1px solid #eee; border-radius:8px; padding:12px 15px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        <div class="body-text" style="font-weight:bold;">{{ $student->batch->name }}</div>
                        <a href="{{ route('lectures.index') }}" class="tf-button" style="background:#FFB020; color:#111; font-size:12px; padding:5px 14px; text-decoration:none;">View Lectures</a>
                    </div>
                </div>

                {{-- ========== HOLIDAYS & ANNOUNCEMENTS ========== --}}
                <div class="wg-box p-20 mb-20">
                    <h5 class="mb-20">Holidays & Announcements</h5>
                    <div style="background:#bde3f7; border-radius:8px; padding:15px;">
                        <div class="body-text mb-15" style="font-weight:bold;">📅 Upcoming Sunday Holidays</div>
                        @foreach ($holidays as $holiday)
                            <div class="mb-10" style="{{ !$loop->last ? 'border-bottom:1px solid rgba(255,255,255,.5); padding-bottom:10px;' : '' }}">
                                <div class="body-text" style="font-weight:bold; color:#1d4ed8;">
                                    Sunday Holiday
                                    <span style="background:#3b82f6; color:#fff; font-size:10px; padding:2px 8px; border-radius:10px; margin-left:5px;">Holiday</span>
                                </div>
                                <div class="text-tiny" style="color:#374151;">Weekly holiday — {{ $holiday->format('d M Y') }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Profile buttons → info alert
    document.querySelectorAll('.edit-profile-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            Swal.fire({
                icon: 'info',
                title: 'Profile Update',
                text: 'Contact your admin/teacher to update your profile details.',
                confirmButtonColor: '#FF5200'
            });
        });
    });
});
</script>
@endsection