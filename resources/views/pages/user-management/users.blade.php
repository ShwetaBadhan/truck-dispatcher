@extends('layout.master')
@section('content')
    <!-- section-content-right -->
    <div class="section-content-right">
        <!-- main-content -->
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
            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: "{{ session('error') }}",
                            timer: 2500,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                    });
                </script>
            @endif

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    {{-- Breadcrumbs & Header --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <h3>All Users</h3>
                    </div>

                    <div class="wg-box">
                        {{-- Search & Add New --}}
                        <div class="flex items-center justify-between gap10 flex-wrap mb-20">
                            <form class="form-search" method="GET" action="{{ route('users.index') }}"
                                style="display: flex; gap: 10px; flex-grow: 1;">
                                <input type="text" placeholder="Search..." name="search" value="{{ request('search') }}"
                                    style="flex-grow: 1;">
                                <button class="tf-button" type="submit"><i class="icon-search"></i></button>
                                @if (request('search'))
                                    <a href="{{ route('users.index') }}" class="tf-button"
                                        style="background: #dc3545; color: white; text-decoration: none; padding: 8px 15px;">Clear</a>
                                @endif
                            </form>
                            <button type="button" class="tf-button px-40" data-bs-toggle="modal"
                                data-bs-target="#createUserModal">
                                <i class="icon-plus"></i> Add new
                            </button>
                        </div>

                        {{-- Table --}}
                        <div class="wg-table table-all-user">
                            <ul class="table-title -1 flex gap20 mb-14" style="align-items: center;">
                                <li style="flex: 2;">
                                    <div class="body-title">User</div>
                                </li>
                                <li style="flex: 1;">
                                    <div class="body-title">Phone</div>
                                </li>
                                <li style="flex: 1.5;">
                                    <div class="body-title">Email</div>
                                </li>
                                <li style="flex: 1;">
                                    <div class="body-title">Role</div>
                                </li>
                                <li style="flex: 1;">
                                    <div class="body-title">Status</div>
                                </li>
                                <li style="flex: 1;">
                                    <div class="body-title">Action</div>
                                </li>
                            </ul>

                            <ul class="flex flex-column">
                                @forelse($users as $user)
                                    <li class="wg-product item-row gap20" style="align-items: center;">
                                        {{-- User Info with Photo --}}
                                        <div class="name flex-grow"
                                            style="flex: 2; display: flex; align-items: center; gap: 15px;">
                                            <div class="image rounded-circle"
                                                style="width: 45px; height: 45px; overflow: hidden; flex-shrink: 0;">
                                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('images/avatar/user-2.png') }}"
                                                    alt="image" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div class="title"><a href="#" class="body-text">{{ $user->name }}</a>
                                            </div>
                                        </div>

                                        <div class="body-text" style="flex: 1;">{{ $user->phone ?? 'N/A' }}</div>
                                        <div class="body-text" style="flex: 1.5;">{{ $user->email }}</div>

                                        <div class="body-text" style="flex: 1;">
                                            @if ($user->roles->isNotEmpty())
                                                <span
                                                    style="color: #28a745; font-weight: bold;">{{ $user->roles->pluck('name')->first() }}</span>
                                            @else
                                                Member
                                            @endif
                                        </div>

                                        {{-- Status Badge --}}
                                        <div class="body-text" style="flex: 1;">
                                            @if ($user->status)
                                                <span
                                                    style="background: #28a745; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Active</span>
                                            @else
                                                <span
                                                    style="background: #dc3545; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Inactive</span>
                                            @endif
                                        </div>

                                        {{-- Actions --}}
                                        <div class="list-icon-function"
                                            style="flex: 1; display: flex; gap: 15px; align-items: center;">
                                           

                                            <button type="button" class="item edit edit-user-btn" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal"
                                                data-update-url="{{ route('users.update', $user->id) }}"
                                                data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}" data-phone="{{ $user->phone }}"
                                                data-role="{{ $user->roles->pluck('name')->first() }}"
                                                data-status="{{ $user->status }}"
                                                data-photo="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : '' }}"
                                                style="background: none; border: none; cursor: pointer;">
                                                <i class="icon-edit-3"></i>
                                            </button>

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="delete-form" style="display: inline;">
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
                                        style="padding: 20px; text-align: center; width: 100%; color: red;">No users found.
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        {{-- Pagination --}}
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10">
                            <div class="text-tiny text-surface-2">Showing {{ $users->firstItem() ?? 0 }} to
                                {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries</div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- 1. CREATE USER MODAL --}}
            {{-- ========================================== --}}
            <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Add New User</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" name="name" class="form-control border-secondary" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control border-secondary" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control border-secondary">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="select border-secondary">
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password *</label>
                                    <input type="password" name="password" class="form-control border-secondary"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm Password *</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control border-secondary" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Select Role *</label>
                                    <select name="role" class="select border-secondary" required>
                                        <option value="">-- Choose Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profile Photo</label>
                                    <input type="file" name="profile_photo" class="form-control border-secondary">
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn tf-button" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn tf-button">Save User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ========================================== --}}
            {{-- 2. EDIT USER MODAL --}}
            {{-- ========================================== --}}
            <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="" method="POST" id="editUserForm" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="modal-body row">
                                <div class="col-12 mb-3 text-center">
                                    <img id="current_photo_preview" src="" alt="Current Photo"
                                        style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; display: none; margin-bottom: 10px; border: 2px solid #4b5563;">
                                    <label class="form-label d-block">Update Profile Photo</label>
                                    <input type="file" name="profile_photo" class="form-control border-secondary">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name *</label>
                                    <input type="text" name="name" id="edit_name"
                                        class="form-control border-secondary" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" id="edit_email"
                                        class="form-control border-secondary" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" id="edit_phone"
                                        class="form-control border-secondary">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="edit_status" class="select border-secondary">
                                        <option value="" disabled>Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">New Password <small>(Leave blank to keep
                                            current)</small></label>
                                    <input type="password" name="password" class="form-control border-secondary">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control border-secondary">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Select Role *</label>
                                    <select name="role" id="edit_role" class="select border-secondary" required>
                                        <option value="">-- Choose Role --</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn tf-button" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn tf-button">Update User</button>
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
    {{-- JavaScript for Edit Modal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-user-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('editUserForm').action = this.getAttribute(
                        'data-update-url');
                    document.getElementById('edit_name').value = this.getAttribute('data-name');
                    document.getElementById('edit_email').value = this.getAttribute('data-email');
                    document.getElementById('edit_phone').value = this.getAttribute('data-phone');
                    document.getElementById('edit_role').value = this.getAttribute('data-role');
                    document.getElementById('edit_status').value = this.getAttribute('data-status');

                    let photoUrl = this.getAttribute('data-photo');
                    let previewImg = document.getElementById('current_photo_preview');
                    if (photoUrl) {
                        previewImg.src = photoUrl;
                        previewImg.style.display = 'block';
                    } else {
                        previewImg.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete Confirmation SweetAlert
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Normal submit ko rok dein

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
