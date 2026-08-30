@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            @if (session('success'))
                <script>document.addEventListener('DOMContentLoaded', function() { Swal.fire({ icon: 'success', title: 'Done!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false }); });</script>
            @endif

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <h3>Students</h3>
                        <a href="{{ route('students.create') }}" class="tf-button" style="background:#FF5200;color:#fff;text-decoration:none;"><i class="icon-plus"></i> Register Student</a>
                    </div>

                    <div class="wg-box">
                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items:center;">
                                <li style="flex:3;"><div class="body-title">Student</div></li>
                                <li style="flex:2;"><div class="body-title">Phone</div></li>
                                <li style="flex:2;"><div class="body-title">Batch</div></li>
                                <li style="flex:3;"><div class="body-title">Actions</div></li>
                            </ul>
                            <ul class="flex flex-column">
                                @forelse ($students as $student)
                                    <li class="wg-product item-row gap20" style="align-items:center;">
                                        <div class="body-text" style="flex:3; font-weight:bold;">
                                            {{ $student->name }}
                                            <div class="text-tiny">{{ $student->email }}</div>
                                        </div>
                                        <div class="body-text" style="flex:2;">{{ $student->phone ?? '-' }}</div>
                                        <div class="body-text" style="flex:2;">
                                            @if ($student->batch)
                                                <span style="background:#d1e7dd;color:#0f5132;padding:4px 10px;border-radius:4px;font-size:12px;">{{ $student->batch->name }}</span>
                                            @else
                                                <span style="background:#f8d7da;color:#842029;padding:4px 10px;border-radius:4px;font-size:12px;">Not Assigned</span>
                                            @endif
                                        </div>
                                        <div class="list-icon-function" style="flex: 2; display: flex; gap: 10px; align-items: center;">
                                            {{-- ✅ EDIT BUTTON --}}
                                            <a href="{{ route('students.edit', $student->id) }}" class="item edit" style="text-decoration: none;">
                                                    <i class="icon-edit-3"></i>
                                            </a>

                                            <button type="button" class="tf-button assign-batch-btn" data-bs-toggle="modal" data-bs-target="#assignBatchModal"
                                                data-student-id="{{ $student->id }}" data-batch-id="{{ $student->batch_id }}"
                                                style="font-size:12px;padding:5px 12px;">Assign Batch</button>

                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="delete-form" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="item trash" style="background:none;border:none;cursor:pointer;color:#dc3545;"><i class="icon-trash-2"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center" style="padding:20px;width:100%;color:red;">No students registered yet.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Assign Batch Modal --}}
            <div class="modal fade" id="assignBatchModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" method="POST" id="assignBatchForm">
                            @csrf
                            <div class="modal-body">
                                <label class="body-title d-block mb-10">Select Batch</label>
                                <select name="batch_id" id="assign_batch_select" class="select" required>
                                    <option value="">Select Batch</option>
                                    @foreach ($batches as $b)<option value="{{ $b->id }}">{{ $b->name }}</option>@endforeach
                                </select>
                            </div>
                            <div class="modal-footer"><button type="submit" class="tf-button" style="background:#FF5200;color:#fff;">Assign</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Assign Batch
                    document.querySelectorAll('.assign-batch-btn').forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            document.getElementById('assignBatchForm').action = '/students/' + this.dataset.studentId + '/assign-batch';
                            document.getElementById('assign_batch_select').value = this.dataset.batchId || '';
                        });
                    });

                    // ✅ Delete Confirmation (Swal + fallback)
                    document.querySelectorAll('.delete-form').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();

                            var doDelete = function() { form.submit(); };

                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: 'This student will be permanently deleted!',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Yes, delete it!',
                                    cancelButtonText: 'Cancel'
                                }).then(function(r) {
                                    if (r.isConfirmed) doDelete();
                                });
                            } else {
                                // Agar Swal load na ho to browser ka confirm
                                if (confirm('Are you sure you want to delete this student?')) doDelete();
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
@endsection