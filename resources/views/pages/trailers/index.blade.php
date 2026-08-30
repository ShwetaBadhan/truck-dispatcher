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
            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Restricted!',
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
                    {{-- Header --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>Trailer List</h3>
                            <div class="text-tiny">Manage saved trailers for dispatcher training practice.</div>
                        </div>
                        <div class="flex items-center gap10">
                            <a href="{{ route('trailers.index') }}" class="tf-button">All Trailers</a>
                            <a href="{{ route('trailers.index', ['filter' => 'my']) }}" class="tf-button"
                                style="{{ request('filter') === 'my' ? 'background:#1f2937; color:#fff;' : '' }} text-decoration: none;">My
                                Trailers</a>
                            <a href="{{ route('trailers.create') }}" class="tf-button"
                                style="background: #FF5200; color: #fff; text-decoration: none;"><i class="icon-plus"></i>
                                Add Trailer</a>
                        </div>
                    </div>

                    {{-- Filters --}}
                    <div class="wg-box mb-20">
                        <form method="GET" action="{{ route('trailers.index') }}">
                            @if (request('filter') === 'my')
                                <input type="hidden" name="filter" value="my">
                            @endif
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="body-title mb-10 d-block">Search Number</label>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Trailer number" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">Ownership Type</label>
                                    <select name="ownership_type" class="select">
                                        <option value="">All Ownership Types</option>
                                        @foreach ($ownershipTypes as $type)
                                            <option value="{{ $type }}" @selected(request('ownership_type') == $type)>
                                                {{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 d-flex align-items-end gap10">
                                    <button type="submit" class="tf-button"
                                        style="background:#1f2937; color:#fff;">Search</button>
                                    <a href="{{ route('trailers.index', request('filter') === 'my' ? ['filter' => 'my'] : []) }}"
                                        class="tf-button" style="text-decoration: none;">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 mb-20">
                            <h4>Saved Trailers</h4>
                            <span class="text-tiny">{{ $trailers->total() }} Records</span>
                        </div>

                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items: center;">
                                <li style="flex: 2;">
                                    <div class="body-title">Number</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Ownership</div>
                                </li>
                                <li style="flex: 1;">
                                    <div class="body-title">Status</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">License Plate</div>
                                </li>
                                <li style="flex: 3;">
                                    <div class="body-title">Details</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Owner</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Actions</div>
                                </li>
                            </ul>

                            <ul class="flex flex-column">
                                @forelse($trailers as $trailer)
                                    <li class="wg-product item-row gap20" style="align-items: center;">
                                        <div class="body-text" style="flex: 2; font-weight: bold;">
                                            {{ $trailer->trailer_number }}
                                            <div class="text-tiny">VIN: {{ $trailer->vin ?? '-' }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 2;">{{ $trailer->ownership_type }}</div>
                                        <div class="body-text" style="flex: 1;">
                                            @if ($trailer->status)
                                                <span
                                                    style="background: #d1e7dd; color: #0f5132; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Active</span>
                                            @else
                                                <span
                                                    style="background: #f8d7da; color: #842029; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Inactive</span>
                                            @endif
                                        </div>
                                        <div class="body-text" style="flex: 2;">
                                            {{ $trailer->license_plate_number ?? '-' }}
                                            <div class="text-tiny">Exp:
                                                {{ $trailer->license_plate_expiration?->format('Y-m-d') ?? '-' }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 3;">
                                            {{ trim($trailer->make . ' ' . $trailer->model) ?: '-' }}
                                            <div class="text-tiny">Year: {{ $trailer->year ?? '-' }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 2;">
                                            {{ $trailer->user?->name ?? 'Unknown' }}
                                            @if (auth()->id() === $trailer->user_id)
                                                <div class="text-tiny" style="color: #28a745;">Your trailer</div>
                                            @else
                                                <div class="text-tiny" style="color: #6b7280;">Other dispatcher</div>
                                            @endif
                                        </div>
                                        <div class="list-icon-function"
                                            style="flex: 2; display: flex; gap: 10px; align-items: center;">
                                            <a href="{{ route('trailers.show', $trailer->id) }}" class="item eye"
                                                style="text-decoration: none;">
                                                <i class="icon-eye"></i>
                                            </a>
                                            @if (auth()->id() === $trailer->user_id)
                                                <a href="{{ route('trailers.edit', $trailer->id) }}" class="item edit"
                                                    style="text-decoration: none;">
                                                    <i class="icon-edit-3"></i>
                                                </a>
                                                <form action="{{ route('trailers.destroy', $trailer->id) }}" method="POST"
                                                    class="delete-form" style="display: inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="item trash"
                                                        style="background: none; border: none; cursor: pointer; color: #dc3545;">
                                                        <i class="icon-trash-2"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center" style="padding: 20px; width: 100%; color: red;">No trailers
                                        found.</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10">
                            <div class="text-tiny text-surface-2">Showing {{ $trailers->firstItem() ?? 0 }} to
                                {{ $trailers->lastItem() ?? 0 }} of {{ $trailers->total() }} entries</div>
                            {{ $trailers->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Delete Confirmation --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.delete-form').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "This trailer will be permanently deleted!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel'
                            }).then(function(result) {
                                if (result.isConfirmed) form.submit();
                            });
                        });
                    });
                });
            </script>
        </div>
    </div>
@endsection
