@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            <div class="main-content-inner">
                <div class="main-content-wrap">
                    <div class="wg-box p-20">
                        <h3 class="mb-10">Edit Profile</h3>
                        <div class="text-tiny mb-20">Keep your dispatcher training profile, documents, and photo up to date.</div>
                        @include('pages.students.partials.profile-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection