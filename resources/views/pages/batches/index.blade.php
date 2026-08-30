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
                        <h3>Batches</h3>
                        <button type="button" class="tf-button" style="background:#FF5200;color:#fff;" data-bs-toggle="modal" data-bs-target="#createBatchModal">
                            <i class="icon-plus"></i> Add Batch
                        </button>
                    </div>

                    <div class="wg-box">
                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items:center;">
                                <li style="flex:1;"><div class="body-title">#</div></li>
                                <li style="flex:3;"><div class="body-title">Batch Name</div></li>
                                <li style="flex:2;"><div class="body-title">Students</div></li>
                                <li style="flex:2;"><div class="body-title">Status</div></li>
                                <li style="flex:2;"><div class="body-title">Actions</div></li>
                            </ul>
                            <ul class="flex flex-column">
                                @forelse ($batches as $batch)
                                    <li class="wg-product item-row gap20" style="align-items:center;">
                                        <div class="body-text" style="flex:1;">{{ $loop->iteration }}</div>
                                        <div class="body-text" style="flex:3; font-weight:bold;">{{ $batch->name }}</div>
                                        <div class="body-text" style="flex:2;">{{ $batch->students_count }} Students</div>
                                        <div class="body-text" style="flex:2;">
                                            @if ($batch->status)
                                                <span style="background:#d1e7dd;color:#0f5132;padding:4px 10px;border-radius:4px;font-size:12px;">Active</span>
                                            @else
                                                <span style="background:#f8d7da;color:#842029;padding:4px 10px;border-radius:4px;font-size:12px;">Inactive</span>
                                            @endif
                                        </div>
                                        <div style="flex:2; display:flex; gap:10px;">
                                            <button type="button" class="item edit edit-batch-btn" data-bs-toggle="modal" data-bs-target="#editBatchModal"
                                                data-update-url="{{ route('batches.update', $batch->id) }}"
                                                data-name="{{ $batch->name }}" data-status="{{ $batch->status ? 1 : 0 }}"
                                                style="background:none;border:none;cursor:pointer;">
                                                <i class="icon-edit-3"></i>
                                            </button>
                                            <form action="{{ route('batches.destroy', $batch->id) }}" method="POST" class="delete-form" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="item trash" style="background:none;border:none;cursor:pointer;color:#dc3545;"><i class="icon-trash-2"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center" style="padding:20px;width:100%;color:red;">No batches found.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Create Modal --}}
            <div class="modal fade" id="createBatchModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('batches.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3"><label class="body-title d-block mb-10">Batch Name *</label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g. PRACTICAL BATCH 2" required></div>
                                <div class="mb-3"><label class="body-title d-block mb-10">Status</label>
                                    <select name="status" class="form-select"><option value="1" selected>Active</option><option value="0">Inactive</option></select></div>
                            </div>
                            <div class="modal-footer"><button type="submit" class="tf-button" style="background:#FF5200;color:#fff;">Save Batch</button></div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Edit Modal --}}
            <div class="modal fade" id="editBatchModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" method="POST" id="editBatchForm">
                            @csrf @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3"><label class="body-title d-block mb-10">Batch Name *</label>
                                    <input type="text" name="name" id="edit_batch_name" class="form-control" required></div>
                                <div class="mb-3"><label class="body-title d-block mb-10">Status</label>
                                    <select name="status" id="edit_batch_status" class="form-select"><option value="1">Active</option><option value="0">Inactive</option></select></div>
                            </div>
                            <div class="modal-footer"><button type="submit" class="tf-button" style="background:#FF5200;color:#fff;">Update Batch</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.edit-batch-btn').forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            document.getElementById('editBatchForm').action = this.dataset.updateUrl;
                            document.getElementById('edit_batch_name').value = this.dataset.name;
                            document.getElementById('edit_batch_status').value = this.dataset.status;
                        });
                    });
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