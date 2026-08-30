@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            @if ($errors->any())
                <script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'error', title: 'Oops...', html: "{!! implode('<br>', $errors->all()) !!}" }); });</script>
            @endif

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div><h3>Edit Lecture</h3><div class="text-tiny">{{ $lecture->syllabus?->topic }}</div></div>
                        <a href="{{ route('lectures.index') }}" class="tf-button" style="text-decoration:none;">Back to Lectures</a>
                    </div>

                    <div class="wg-box p-20">
                        @include('pages.lectures.partials.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection