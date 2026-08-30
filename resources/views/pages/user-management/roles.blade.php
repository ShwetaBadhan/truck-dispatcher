@extends('layout.master')

@section('content')
<div class="section-content-right">
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

        {{-- Error Message (Swal) --}}
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

        {{-- Custom Styles --}}
        <style>
            .multi-select { position: relative; cursor: pointer; }
            .multi-select .selected-tags { min-height: 20px; display: flex; flex-wrap: wrap; gap: 6px; padding: 8px; background: #f9fafb; }
            .multi-select .tag-item { background: #FF5200; color: #fff; padding: 4px 10px; border-radius: 4px; font-size: 12px; display: flex; align-items: center; gap: 6px; }
            .multi-select .tag-item i { cursor: pointer; font-style: normal; font-weight: bold; }
            .multi-select .toggle-dropdown { position: absolute; right: 12px; top: 12px; color: #9ca3af; }
            .multi-select .list-dropdown { display: none; position: absolute; top: 100%; left: 0; right: 0; background: #fff; color: #000; border: 1px solid #374151; border-radius: 6px; max-height: 200px; overflow-y: auto; z-index: 1050; margin-top: 4px; }
            .multi-select .list-dropdown.open { display: block; }
            .multi-select .list-dropdown div { padding: 8px 12px; cursor: pointer; }
            .multi-select .list-dropdown div:hover { background: #f3f4f6; }
            .multi-select .list-dropdown div.active { background: #FF5200; color: #fff; }
        </style>

        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                    <h3>All Roles</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                        <li><a href="{{ route('dashboard') }}"><div class="text-tiny">Dashboard</div></a></li>
                        <li><i class="icon-chevron-right"></i></li>
                        <li><div class="text-tiny">All Roles</div></li>
                    </ul>
                </div>

                <div class="wg-box">
                    {{-- Search & Add New --}}
                    <div class="flex items-center justify-between gap10 flex-wrap mb-20">
                        <form class="form-search" method="GET" action="{{ route('roles.index') }}" style="display: flex; gap: 10px; flex-grow: 1;">
                            <input type="text" placeholder="Search role..." name="search" value="{{ request('search') }}" style="flex-grow: 1;">
                            <button class="tf-button" type="submit"><i class="icon-search"></i></button>
                            @if(request('search'))
                                <a href="{{ route('roles.index') }}" class="tf-button" style="background: #dc3545; color: white; text-decoration: none; padding: 8px 15px;">Clear</a>
                            @endif
                        </form>
                        <button type="button" class="tf-button px-40" data-bs-toggle="modal" data-bs-target="#createRoleModal" style="background: #FF5200; color: white;">
                            <i class="icon-plus"></i> Add New Role
                        </button>
                    </div>

                    {{-- Table --}}
                    <div class="wg-table table-all-user">
                        <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items: center;">
                            <li style="flex: 1;"><div class="body-title">#</div></li>
                            <li style="flex: 2;"><div class="body-title">Role Name</div></li>
                            <li style="flex: 1;"><div class="body-title">Status</div></li>
                            <li style="flex: 3;"><div class="body-title">Assigned Permissions</div></li>
                            <li style="flex: 2;"><div class="body-title">Actions</div></li>
                        </ul>

                        <ul class="flex flex-column">
                            @forelse($roles as $role)
                                <li class="wg-product item-row gap20" style="align-items: center;">
                                    <div class="body-text" style="flex: 1;">{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</div>
                                    <div class="body-text" style="flex: 2; font-weight: bold;">{{ ucfirst($role->name) }}</div>
                                    <div class="body-text" style="flex: 1;">
                                        @if($role->status)
                                            <span style="background: #28a745; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Active</span>
                                        @else
                                            <span style="background: #dc3545; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Inactive</span>
                                        @endif
                                    </div>
                                    <div class="body-text" style="flex: 3; display: flex; flex-wrap: wrap; gap: 5px;">
                                        @forelse($role->permissions->take(5) as $p)
                                            <span style="background: rgba(255,82,0,0.15); color: #FF5200; border: 1px solid #FF5200; padding: 2px 8px; border-radius: 4px; font-size: 11px;">{{ $p->name }}</span>
                                        @empty
                                            <span style="color: #6b7280; font-size: 12px;">No permissions</span>
                                        @endforelse
                                        @if($role->permissions->count() > 5)
                                            <span style="color: #6b7280; font-size: 11px;">+{{ $role->permissions->count() - 5 }} more</span>
                                        @endif
                                    </div>
                                    <div class="list-icon-function" style="flex: 2; display: flex; gap: 10px; align-items: center;">
                                        {{-- Edit Button --}}
                                        <button type="button" class="item edit edit-user-btn"
                                            data-bs-toggle="modal" data-bs-target="#editRoleModal"
                                            data-update-url="{{ route('roles.update', $role->id) }}"
                                            data-name="{{ $role->name }}"
                                            data-status="{{ $role->status }}"
                                         style="background: none; border: none; cursor: pointer;">
                                                <i class="icon-edit-3"></i>
                                            </button>

                                        {{-- Assign Permissions Button --}}
                                        <button type="button" class="tf-button assign-permission-btn" 
                                            data-bs-toggle="modal" data-bs-target="#assignPermissionModal"
                                            data-role-name="{{ $role->name }}"
                                            data-assign-url="{{ route('roles.assign-permissions', $role->id) }}"
                                            data-permissions="{{ $role->permissions->pluck('name')->toJson() }}"
                                            style="background: #FF5200; color: white; font-size: 11px; padding: 4px 10px;">
                                            <i class="icon-key"></i> Permissions
                                        </button>

                                        {{-- Delete Form --}}
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="delete-form" style="display: inline;">
                                            @csrf @method('DELETE')
                                             <button type="submit" class="item trash"
                                                    style="background: none; border: none; cursor: pointer; color: #dc3545;">
                                                    <i class="icon-trash-2"></i>
                                                </button>
                                        </form>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center" style="padding: 20px; text-align: center; width: 100%; color: red;">No roles found.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Pagination --}}
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10">
                        <div class="text-tiny text-surface-2">Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() }} entries</div>
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- CREATE ROLE MODAL --}}
        {{-- ========================================== --}}
        <div class="modal fade" id="createRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Add New Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. editor, manager" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="select" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn tf-button" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn tf-button" style="background: #FF5200; color: white;">Create Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- EDIT ROLE MODAL --}}
        {{-- ========================================== --}}
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="" method="POST" id="editRoleForm">
                        @csrf @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Role Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_role_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="edit_role_status" class="select" required>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn tf-button" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn tf-button" style="background: #FF5200; color: white;">Update Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ========================================== --}}
        {{-- ASSIGN PERMISSIONS MODAL (Multi-Select) --}}
        {{-- ========================================== --}}
        <div class="modal fade" id="assignPermissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title">Assign Permissions — <span id="assign_role_name" style="color: #FF5200;"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="" method="POST" id="assignPermissionForm">
                        @csrf
                        <div class="modal-body">
                            <fieldset class="category">
                                <div class="body-title mb-10">Select Permissions <span class="tf-color-1">*</span></div>
                                
                                <div class="multi-select" id="permissionMultiSelect">
                                    <div class="selected-tags"></div>
                                    <div class="toggle-dropdown">
                                        <i class="icon icon-chevron-down"></i>
                                    </div>
                                    <div class="list-dropdown">
                                        @foreach($permissions as $permission)
                                            <div data-value="{{ $permission->name }}">{{ $permission->name }}</div>
                                        @endforeach
                                    </div>
                                </div>

                                <div id="permissionCheckboxes" style="display: none;">
                                    @foreach($permissions as $permission)
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn tf-button" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn tf-button" style="background: #FF5200; color: white;">Assign Permissions</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Role Modal Data Populate
    document.querySelectorAll('.edit-role-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editRoleForm').action = this.getAttribute('data-update-url');
            document.getElementById('edit_role_name').value = this.getAttribute('data-name');
            document.getElementById('edit_role_status').value = this.getAttribute('data-status');
        });
    });

    // Delete Confirmation
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

    // Multi-Select for Permissions
    const multiSelect = document.getElementById('permissionMultiSelect');
    const tagsContainer = multiSelect.querySelector('.selected-tags');
    const dropdown = multiSelect.querySelector('.list-dropdown');
    const toggleBtn = multiSelect.querySelector('.toggle-dropdown');

    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('open');
    });

    document.addEventListener('click', function() {
        dropdown.classList.remove('open');
    });
    multiSelect.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    function toggleOption(option) {
        const value = option.getAttribute('data-value');
        const checkbox = document.querySelector('#permissionCheckboxes input[value="' + value + '"]');
        const isSelected = option.classList.toggle('active');

        if (checkbox) checkbox.checked = isSelected;

        if (isSelected) {
            const tag = document.createElement('div');
            tag.className = 'tag-item';
            tag.setAttribute('data-value', value);
            tag.innerHTML = value + ' <i>✕</i>';
            tag.querySelector('i').addEventListener('click', function() {
                toggleOption(option);
            });
            tagsContainer.appendChild(tag);
        } else {
            const tag = tagsContainer.querySelector('.tag-item[data-value="' + value + '"]');
            if (tag) tag.remove();
        }
    }

    dropdown.querySelectorAll('div').forEach(option => {
        option.addEventListener('click', function() {
            toggleOption(this);
        });
    });

    // Assign Permission Modal Data Populate
    document.querySelectorAll('.assign-permission-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('assignPermissionForm').action = this.getAttribute('data-assign-url');
            document.getElementById('assign_role_name').textContent = this.getAttribute('data-role-name');

            dropdown.querySelectorAll('div.active').forEach(o => o.classList.remove('active'));
            tagsContainer.innerHTML = '';
            document.querySelectorAll('#permissionCheckboxes input').forEach(c => c.checked = false);

            const assigned = JSON.parse(this.getAttribute('data-permissions') || '[]');
            assigned.forEach(name => {
                const option = dropdown.querySelector('div[data-value="' + name + '"]');
                if (option) toggleOption(option);
            });
        });
    });
});
</script>
@endpush