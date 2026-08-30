@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            @if (session('success'))
                <script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'success', title: 'Done!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false }); });</script>
            @endif

            @php $isStudent = (bool) ($student ?? null); @endphp

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>Daily Lectures</h3>
                            <div class="text-tiny">View daily lectures added by your teacher for your selected assigned batch.</div>
                        </div>
                        <div class="flex items-center gap10">
                           @can('create-lectures')
                                <a href="{{ route('lectures.create') }}" class="tf-button" style="background:#FF5200;color:#fff;text-decoration:none;"><i class="icon-plus"></i> Add Lecture</a>
                               
                           @endcan
                            
                            <span class="tf-button" style="background:#5a5bd8;color:#fff;">{{ $lectures->total() }} Lectures</span>
                        </div>
                    </div>

                    @if ($isStudent && $student->batch)
                        <div class="mb-20">
                            <span class="tf-button" style="background:#5a5bd8;color:#fff;">{{ $student->batch->name }}</span>
                        </div>
                    @endif

                    <div class="wg-box">
                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items:center;">
                                <li style="flex:1;"><div class="body-title">S.No</div></li>
                                <li style="flex:2;"><div class="body-title">Date</div></li>
                                <li style="flex:2;"><div class="body-title">Batch</div></li>
                                <li style="flex:3;"><div class="body-title">Topic</div></li>
                                <li style="flex:2;"><div class="body-title">Teacher</div></li>
                                <li style="flex:3;"><div class="body-title">Comments</div></li>
                                <li style="flex:1;"><div class="body-title">PDF</div></li>
                              @can('view-action')  @if (!$isStudent)<li style="flex:1;"><div class="body-title">Actions</div></li>@endif @endcan
                            </ul>

                            <ul class="flex flex-column">
                                @forelse ($lectures as $lecture)
                                    <li class="wg-product item-row gap20" style="align-items:center;">
                                        <div class="body-text" style="flex:1;">{{ $loop->iteration + ($lectures->currentPage() - 1) * $lectures->perPage() }}</div>
                                        <div class="body-text" style="flex:2;">{{ $lecture->lecture_date?->format('M d, Y') }}</div>
                                        <div class="body-text" style="flex:2;">{{ $lecture->batch?->name ?? '-' }}</div>
                                        <div class="body-text" style="flex:3; font-weight:bold;">{{ $lecture->syllabus?->topic ?? '-' }}</div>
                                        <div class="body-text" style="flex:2;">{{ $lecture->teacher?->name ?? '-' }}</div>
                                        <div class="body-text" style="flex:3;">{{ $lecture->comments ?: '-' }}</div>
                                        <div class="body-text" style="flex:1;">
                                            @if ($lecture->pdf_path)
                                                <a href="{{ $lecture->pdf_url }}" target="_blank" style="color:#5a5bd8;font-weight:bold;text-decoration:none;">View PDF</a>
                                            @else - @endif
                                        </div>
                                        @if (!$isStudent)
                                        @can('view-action')
                                            <div class="list-icon-function" style="flex: 2; display: flex; gap: 10px; align-items: center;">
                                              
                                                @can('edit-lectures')
                                                <a href="{{ route('lectures.edit', $lecture->id) }}" class="item edit" style="text-decoration:none;"><i class="icon-edit-3"></i></a>
                                                    
                                                @endcan
                                                @can('delete-lectures')
                                                     <form action="{{ route('lectures.destroy', $lecture->id) }}" method="POST" class="delete-form" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="item trash" style="background:none;border:none;cursor:pointer;color:#dc3545;"><i class="icon-trash-2"></i></button>
                                                </form>
                                                @endcan
                                               
                                            </div>
                                        @endcan
                                            
                                        @endif
                                    </li>
                                @empty
                                    <li class="text-center" style="padding:30px;width:100%;">
                                        @if ($isStudent && !$student->batch_id)
                                            No regular batches are assigned to your login yet.
                                        @else
                                            No lectures found.
                                        @endif
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="divider"></div>
                        {{ $lectures->links() }}
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.delete-form').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            Swal.fire({ title: 'Are you sure?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Yes, delete it!' })
                                .then(function(r) { if (r.isConfirmed) form.submit(); });
                        });
                    });
                });
            </script>
        </div>
    </div>
@endsection