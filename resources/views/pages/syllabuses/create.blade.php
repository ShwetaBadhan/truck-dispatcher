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
                            <h3>Add Syllabus</h3>
                            <div class="text-tiny">Create topic, short details, and upload PDF.</div>
                        </div>

                        <a href="{{ route('syllabuses.index') }}" class="tf-button" style="text-decoration:none;">
                            Back to Syllabus List
                        </a>
                    </div>

                    <div class="wg-box p-20">
                        <form action="{{ route('syllabuses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">
                                        Topic <span class="tf-color-1">*</span>
                                    </label>
                                    <input type="text" name="topic" class="form-control"
                                           value="{{ old('topic') }}" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">
                                        Status <span class="tf-color-1">*</span>
                                    </label>
                                    <select name="status" class="form-select" required>
                                        <option value="1" @selected(old('status', '1') == '1')>Active</option>
                                        <option value="0" @selected(old('status') == '0')>Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="body-title mb-10 d-block">Short Details</label>
                                    <textarea name="short_details" class="form-control" rows="5"
                                              placeholder="Enter short details...">{{ old('short_details') }}</textarea>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="body-title mb-10 d-block">Upload PDF</label>
                                    <input type="file" name="pdf" class="form-control" accept="application/pdf">
                                    <div class="text-tiny mt-2">Only PDF allowed. Max size 10MB.</div>
                                </div>
                            </div>

                            <div class="flex items-center gap10 mt-20">
                                <button type="submit" class="tf-button" style="background:#FF5200; color:white;">
                                    Save Syllabus
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