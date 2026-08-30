@extends('layout.master')
@section('content')
    <!-- section-content-right -->
    <div class="section-content-right">
        <!-- main-content -->
        <div class="main-content">
            {{-- Success Message (Swal) --}}
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

            {{-- Validation Errors (Swal) --}}
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
                        <h3>All Permissions</h3>
                        <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                            <li><a href="{{ route('dashboard') }}">
                                    <div class="text-tiny">Dashboard</div>
                                </a></li>
                            <li><i class="icon-chevron-right"></i></li>
                            <li>
                                <div class="text-tiny">All Permissions</div>
                            </li>
                        </ul>
                    </div>

                    <div class="wg-box">
                        {{-- Search & Add New --}}
                        <div class="flex items-center justify-between gap10 flex-wrap mb-20">
                            <form class="form-search" method="GET" action="{{ route('permissions.index') }}"
                                style="display: flex; gap: 10px; flex-grow: 1;">
                                <input type="text" placeholder="Search permission..." name="search"
                                    value="{{ request('search') }}" style="flex-grow: 1;">
                                <button class="tf-button" type="submit"><i class="icon-search"></i></button>
                                @if (request('search'))
                                    <a href="{{ route('permissions.index') }}" class="tf-button"
                                        style="background: #dc3545; color: white; text-decoration: none; padding: 8px 15px;">Clear</a>
                                @endif
                            </form>
                            <button type="button" class="tf-button px-40" data-bs-toggle="modal"
                                data-bs-target="#createPermissionModal">
                                <i class="icon-plus"></i> Add new
                            </button>
                        </div>

                        {{-- Table --}}
                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items: center;">
                                <li style="flex: 1;">
                                    <div class="body-title">#</div>
                                </li>
                                <li style="flex: 3;">
                                    <div class="body-title">Permission Name</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Status</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Action</div>
                                </li>
                            </ul>

                            <ul class="flex flex-column">
                                @forelse($permissions as $permission)
                                    <li class="wg-product item-row gap20" style="align-items: center;">
                                        <div class="body-text" style="flex: 1;">
                                            {{ $loop->iteration + ($permissions->currentPage() - 1) * $permissions->perPage() }}
                                        </div>
                                        <div class="body-text" style="flex: 3; font-weight: bold;">
                                            {{ ucfirst($permission->name) }}</div>
                                        <div class="body-text" style="flex: 2;">
                                            @if ($permission->status)
                                                <span
                                                    style="background: #28a745; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Active</span>
                                            @else
                                                <span
                                                    style="background: #dc3545; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Inactive</span>
                                            @endif
                                        </div>
                                        <div class="list-icon-function"
                                            style="flex: 2; display: flex; gap: 15px; align-items: center;">
                                            {{-- EDIT BUTTON --}}
                                            <button type="button" class="item edit edit-user-btn"
                                                data-bs-toggle="modal" data-bs-target="#editPermissionModal"
                                                data-update-url="{{ route('permissions.update', $permission->id) }}"
                                                data-name="{{ $permission->name }}" data-status="{{ $permission->status }}"
                                                 style="background: none; border: none; cursor: pointer;">
                                                <i class="icon-edit-3"></i>
                                            </button>

                                            {{-- DELETE FORM --}}
                                            <form action="{{ route('permissions.destroy', $permission->id) }}"
                                                method="POST" class="delete-form" style="display: inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="item trash"
                                                    style="background: none; border: none; cursor: pointer; color: #dc3545;">
                                                    <i class="icon-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center"
                                        style="padding: 20px; text-align: center; width: 100%; color: red;">No permissions
                                        found.</li>
                                @endforelse
                            </ul>
                        </div>

                        {{-- Pagination --}}
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10">
                            <div class="text-tiny text-surface-2">Showing {{ $permissions->firstItem() ?? 0 }} to
                                {{ $permissions->lastItem() ?? 0 }} of {{ $permissions->total() }} entries</div>
                            {{ $permissions->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- CREATE PERMISSION MODAL --}}
            {{-- ========================================== --}}
            <div class="modal fade" id="createPermissionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Add New Permission</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('permissions.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Permission Name *</label>
                                    <input type="text" name="name" placeholder="e.g. edit-users, view-reports"
                                        class="form-control  border-secondary" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="select  border-secondary">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn tf-button" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn tf-button">Save Permission</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- EDIT PERMISSION MODAL --}}
            {{-- ========================================== --}}
            <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Edit Permission</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="" method="POST" id="editPermissionForm">
                            @csrf @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Permission Name *</label>
                                    <input type="text" name="name" id="edit_permission_name"
                                        class="form-control  border-secondary" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="edit_permission_status" class="select  border-secondary">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn tf-button"
                                    style="background: #2563eb; color: white;">Update Permission</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </div>
        <!-- /main-content -->
    </div>
@endsection

@push('scripts')
    {{-- ========================================== --}}
    {{-- JAVASCRIPT (Edit + Delete Confirmation) --}}
    {{-- ========================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Edit Modal Data Populate
            document.querySelectorAll('.edit-permission-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('editPermissionForm').action = this.getAttribute(
                        'data-update-url');
                    document.getElementById('edit_permission_name').value = this.getAttribute(
                        'data-name');
                    document.getElementById('edit_permission_status').value = this.getAttribute(
                        'data-status');
                });
            });

            // Delete Confirmation (SweetAlert)
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
