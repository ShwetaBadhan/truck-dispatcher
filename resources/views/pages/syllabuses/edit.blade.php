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
                            <h3>Edit Syllabus</h3>
                            <div class="text-tiny">Update syllabus: <strong>{{ $syllabus->topic }}</strong></div>
                        </div>

                        <div class="flex items-center gap10">
                            <a href="{{ route('syllabuses.show', $syllabus->id) }}" class="tf-button" style="text-decoration:none;">
                                View Details
                            </a>

                            <a href="{{ route('syllabuses.index') }}" class="tf-button" style="text-decoration:none;">
                                Back to Syllabus List
                            </a>
                        </div>
                    </div>

                    <div class="wg-box p-20">
                        <form action="{{ route('syllabuses.update', $syllabus->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">
                                        Topic <span class="tf-color-1">*</span>
                                    </label>
                                    <input type="text" name="topic" class="form-control"
                                           value="{{ old('topic', $syllabus->topic) }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">
                                        Status <span class="tf-color-1">*</span>
                                    </label>
                                    <select name="status" class="form-select" required>
                                        <option value="1" @selected(old('status', $syllabus->status) == 1)>Active</option>
                                        <option value="0" @selected(old('status', $syllabus->status) == 0)>Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="body-title mb-10 d-block">Short Details</label>
                                    <textarea name="short_details" class="form-control" rows="5">{{ old('short_details', $syllabus->short_details) }}</textarea>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="body-title mb-10 d-block">Replace PDF</label>
                                    <input type="file" name="pdf" class="form-control" accept="application/pdf">
                                    <div class="text-tiny mt-2">Leave empty if you do not want to replace current PDF.</div>

                                    @if ($syllabus->pdf_path)
                                        <div class="mt-3">
                                            <a href="{{ $syllabus->pdf_url }}" target="_blank" class="tf-button"
                                               style="text-decoration:none;">
                                                View Current PDF
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap10 mt-20">
                                <button type="submit" class="tf-button" style="background:#FF5200; color:white;">
                                    Update Syllabus
                                </button>

                                <a href="{{ route('syllabuses.index') }}" class="tf-button"
                                   style="background:#6c757d; color:white; text-decoration:none;">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection