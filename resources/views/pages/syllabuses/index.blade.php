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
                            <h3>Syllabus List</h3>
                            <div class="text-tiny">Manage syllabus topics, short details, and PDF files.</div>
                        </div>

                        @can('create-syllabus')
                            <a href="{{ route('syllabuses.create') }}" class="tf-button"
                           style="background:#FF5200; color:#fff; text-decoration:none;">
                            <i class="icon-plus"></i> Add Syllabus
                        </a>
                        @endcan
                        
                    </div>

                    {{-- Filters --}}
                    <div class="wg-box mb-20">
                        <form method="GET" action="{{ route('syllabuses.index') }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Search Topic / Details</label>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                           class="form-control" placeholder="Search syllabus...">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="body-title mb-10 d-block">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All</option>
                                        <option value="1" @selected(request('status') === '1')>Active</option>
                                        <option value="0" @selected(request('status') === '0')>Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3 d-flex align-items-end gap10">
                                    <button type="submit" class="tf-button" style="background:#1f2937; color:#fff;">
                                        Search
                                    </button>
                                    <a href="{{ route('syllabuses.index') }}" class="tf-button" style="text-decoration:none;">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 mb-20">
                            <h4>Saved Syllabuses</h4>
                            <span class="text-tiny">{{ $syllabuses->total() }} Records</span>
                        </div>

                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items:center;">
                                <li style="flex:3;"><div class="body-title">Topic</div></li>
                                <li style="flex:4;"><div class="body-title">Short Details</div></li>
                                <li style="flex:2;"><div class="body-title">PDF</div></li>
                                <li style="flex:1;"><div class="body-title">Status</div></li>
                                <li style="flex:2;"><div class="body-title">Actions</div></li>
                            </ul>

                            <ul class="flex flex-column">
                                @forelse ($syllabuses as $syllabus)
                                    <li class="wg-product item-row gap20" style="align-items:center;">
                                        <div class="body-text" style="flex:3; font-weight:bold;">
                                            {{ $syllabus->topic }}
                                            <div class="text-tiny">Added by: {{ $syllabus->user?->name ?? 'Unknown' }}</div>
                                        </div>

                                        <div class="body-text" style="flex:4;">
                                            {{ \Illuminate\Support\Str::limit($syllabus->short_details, 100) ?: '-' }}
                                        </div>

                                        <div class="body-text" style="flex:2;">
                                            @if ($syllabus->pdf_path)
                                                <a href="{{ $syllabus->pdf_url }}" target="_blank" class="tf-button"
                                                   style="padding:6px 12px; text-decoration:none;">
                                                    View PDF
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </div>

                                        <div class="body-text" style="flex:1;">
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

                                        <div class="list-icon-function" style="flex:2; display:flex; gap:10px; align-items:center;">
                                            <a href="{{ route('syllabuses.show', $syllabus->id) }}" class="item eye"
                                               style="text-decoration:none;">
                                                <i class="icon-eye"></i>
                                            </a>

                                            @can('edit-syllabus')
                                                <a href="{{ route('syllabuses.edit', $syllabus->id) }}" class="item edit"
                                               style="text-decoration:none;">
                                                <i class="icon-edit-3"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('delete-syllabus')
                                                <form action="{{ route('syllabuses.destroy', $syllabus->id) }}" method="POST"
                                                  class="delete-form" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="item trash"
                                                        style="background:none; border:none; cursor:pointer; color:#dc3545;">
                                                    <i class="icon-trash-2"></i>
                                                </button>
                                            </form>
                                            @endcan
                                            
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center" style="padding:20px; width:100%; color:red;">
                                        No syllabus found.
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="divider"></div>

                        <div class="flex items-center justify-between flex-wrap gap10">
                            <div class="text-tiny text-surface-2">
                                Showing {{ $syllabuses->firstItem() ?? 0 }} to {{ $syllabuses->lastItem() ?? 0 }}
                                of {{ $syllabuses->total() }} entries
                            </div>

                            {{ $syllabuses->links() }}
                        </div>
                    </div>

                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.delete-form').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();

                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'This syllabus and PDF will be deleted!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel'
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        });
                    });
                });
            </script>

        </div>
    </div>
@endsection