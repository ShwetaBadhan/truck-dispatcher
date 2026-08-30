@extends('layout.master')

@section('content')
    <div class="section-content-right">
        <div class="main-content">
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ icon: 'success', title: 'Done!', text: "{{ session('success') }}", timer: 2500, timerProgressBar: true, showConfirmButton: false });
                    });
                </script>
            @endif
            @if (session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({ icon: 'error', title: 'Restricted!', text: "{{ session('error') }}", timer: 2500, timerProgressBar: true, showConfirmButton: false });
                    });
                </script>
            @endif

            <div class="main-content-inner">
                <div class="main-content-wrap">
                    {{-- Header --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>Truck List</h3>
                            <div class="text-tiny">Manage saved truck units for dispatcher training practice.</div>
                        </div>
                        <div class="flex items-center gap10">
                            <a href="{{ route('trucks.index') }}" class="tf-button">All Trucks</a>
                            <a href="{{ route('trucks.index', ['filter' => 'my']) }}" class="tf-button" style="{{ request('filter') === 'my' ? 'background:#1f2937; color:#fff;' : '' }} text-decoration: none;">My Trucks</a>
                            <a href="{{ route('trucks.create') }}" class="tf-button" style="background: #FF5200; color: #fff; text-decoration: none;"><i class="icon-plus"></i> Add Truck</a>
                        </div>
                    </div>

                    {{-- Filters --}}
                    <div class="wg-box mb-20">
                        <form method="GET" action="{{ route('trucks.index') }}">
                            @if (request('filter') === 'my')
                                <input type="hidden" name="filter" value="my">
                            @endif
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="body-title mb-10 d-block">Search Unit / VIN / Plate</label>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Unit number, VIN, plate" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">Status</label>
                                    <select name="status" class="select">
                                        <option value="">All Statuses</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" @selected(request('status') == $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 d-flex align-items-end gap10">
                                    <button type="submit" class="tf-button" style="background:#1f2937; color:#fff;">Search</button>
                                    <a href="{{ route('trucks.index', request('filter') === 'my' ? ['filter' => 'my'] : []) }}" class="tf-button" style="text-decoration: none;">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 mb-20">
                            <h4>Saved Trucks</h4>
                            <span class="text-tiny">{{ $trucks->total() }} Records</span>
                        </div>

                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items: center;">
                                <li style="flex: 2;"><div class="body-title">Unit</div></li>
                                <li style="flex: 2;"><div class="body-title">VIN</div></li>
                                <li style="flex: 2;"><div class="body-title">Plate</div></li>
                                <li style="flex: 3;"><div class="body-title">Truck</div></li>
                                <li style="flex: 2;"><div class="body-title">Status</div></li>
                                <li style="flex: 2;"><div class="body-title">Owner</div></li>
                                <li style="flex: 2;"><div class="body-title">Actions</div></li>
                            </ul>

                            <ul class="flex flex-column">
                                @forelse($trucks as $truck)
                                    @php
                                        $badge = match($truck->status) {
                                            'Available' => 'background:#d1e7dd; color:#0f5132;',
                                            'In Service' => 'background:#cfe2ff; color:#084298;',
                                            default => 'background:#f8d7da; color:#842029;',
                                        };
                                    @endphp
                                    <li class="wg-product item-row gap20" style="align-items: center;">
                                        <div class="body-text" style="flex: 2; font-weight: bold;">
                                            {{ $truck->unit_number }}
                                            <div class="text-tiny">Capacity: {{ number_format($truck->capacity_lbs) }} lbs</div>
                                        </div>
                                        <div class="body-text" style="flex: 2;">{{ $truck->vin ?? '-' }}</div>
                                        <div class="body-text" style="flex: 2;">
                                            {{ $truck->plate_number ?? '-' }}
                                            <div class="text-tiny">{{ strtoupper($truck->plate_state ?? '') }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 3;">
                                            {{ trim($truck->make . ' ' . $truck->model) ?: '-' }}
                                            <div class="text-tiny">Year: {{ $truck->year ?? '-' }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 2;">
                                            <span style="{{ $badge }} padding: 4px 10px; border-radius: 4px; font-size: 12px;">{{ $truck->status }}</span>
                                        </div>
                                        <div class="body-text" style="flex: 2;">
                                            {{ $truck->user?->name ?? 'Unknown' }}
                                            @if (auth()->id() === $truck->user_id)
                                                <div class="text-tiny" style="color: #28a745;">Your truck</div>
                                            @else
                                                <div class="text-tiny" style="color: #6b7280;">Other dispatcher</div>
                                            @endif
                                        </div>
                                        <div class="list-icon-function" style="flex: 2; display: flex; gap: 10px; align-items: center;">
                                            <a href="{{ route('trucks.show', $truck->id) }}" class="item eye" style="text-decoration: none;">
                                                <i class="icon-eye"></i>
                                            </a>
                                            @if (auth()->id() === $truck->user_id)
                                                <a href="{{ route('trucks.edit', $truck->id) }}" class="item edit" style="text-decoration: none;">
                                                    <i class="icon-edit-3"></i>
                                                </a>
                                                <form action="{{ route('trucks.destroy', $truck->id) }}" method="POST" class="delete-form" style="display: inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="item trash" style="background: none; border: none; cursor: pointer; color: #dc3545;">
                                                        <i class="icon-trash-2"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center" style="padding: 20px; width: 100%; color: red;">No trucks found.</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10">
                            <div class="text-tiny text-surface-2">Showing {{ $trucks->firstItem() ?? 0 }} to {{ $trucks->lastItem() ?? 0 }} of {{ $trucks->total() }} entries</div>
                            {{ $trucks->links() }}
                        </div>
                    </div>
                </div>
            </div>

            
           
        </div>
    </div>
@endsection

@push('scripts')
     <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.delete-form').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "This truck will be permanently deleted!",
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
@endpush