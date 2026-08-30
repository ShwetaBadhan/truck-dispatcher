@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">

            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Done!',
                            text: "{{ session('success') }}",
                            timer: 2500,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                    });
                </script>
            @endif

            <div class="main-content-inner">
                <div class="main-content-wrap">

                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>{{ $syllabus->topic }}</h3>
                            <div class="text-tiny">Syllabus details and PDF file.</div>
                        </div>

                        <div class="flex items-center gap10">
                            <a href="{{ route('syllabuses.edit', $syllabus->id) }}" class="tf-button"
                               style="background:#FF5200; color:#fff; text-decoration:none;">
                                Edit Syllabus
                            </a>

                            <a href="{{ route('syllabuses.index') }}" class="tf-button" style="text-decoration:none;">
                                Back to Syllabus List
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">Syllabus Information</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-15">
                                        <div class="body-title">Topic:</div>
                                        <div class="body-text">{{ $syllabus->topic }}</div>
                                    </div>

                                    <div class="col-md-6 mb-15">
                                        <div class="body-title">Status:</div>
                                        <div class="body-text">
                                            @if ($syllabus->status)
                                                <span style="background:#d1e7dd; color:#0f5132; padding:4px 10px; border-radius:4px; font-size:12px;">
                                                    Active
                                                </span>
                                            @else
                                                <span style="background:#f8d7da; color:#842029; padding:4px 10px; border-radius:4px; font-size:12px;">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-15">
                                        <div class="body-title">Added By:</div>
                                        <div class="body-text">{{ $syllabus->user?->name ?? 'Unknown' }}</div>
                                    </div>

                                    <div class="col-md-6 mb-15">
                                        <div class="body-title">Created At:</div>
                                        <div class="body-text">{{ $syllabus->created_at?->format('d M Y h:i A') }}</div>
                                    </div>

                                    <div class="col-12 mb-15">
                                        <div class="body-title">Short Details:</div>
                                        <div class="body-text" style="white-space:pre-line;">
                                            {{ $syllabus->short_details ?: '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-20">
                            <div class="wg-box p-20">
                                <h5 class="mb-20">PDF File</h5>

                                @if ($syllabus->pdf_path)
                                    <a href="{{ $syllabus->pdf_url }}" target="_blank" class="tf-button"
                                       style="background:#FF5200; color:#fff; text-decoration:none; width:100%; justify-content:center;">
                                        View PDF
                                    </a>

                                    <a href="{{ $syllabus->pdf_url }}" download class="tf-button mt-3"
                                       style="text-decoration:none; width:100%; justify-content:center;">
                                        Download PDF
                                    </a>
                                @else
                                    <div class="text-tiny">No PDF uploaded.</div>
                                @endif
                            </div>
                        </div>

                        @if ($syllabus->pdf_path)
                            <div class="col-12 mb-20">
                                <div class="wg-box p-20">
                                    <h5 class="mb-20">PDF Preview</h5>

                                    <iframe src="{{ $syllabus->pdf_url }}"
                                            style="width:100%; height:700px; border:1px solid #ddd; border-radius:8px;">
                                    </iframe>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection