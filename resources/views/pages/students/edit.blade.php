@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            <div class="main-content-inner">
                <div class="main-content-wrap">
                    <div class="wg-box p-20">
                        <h3 class="mb-10">Edit Student</h3>
                        <div class="text-tiny mb-20">Update student profile, photo and documents.</div>
                        @include('pages.students.partials.profile-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection