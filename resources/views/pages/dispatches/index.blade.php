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
                            <h3>Dispatch List</h3>
                            <div class="text-tiny">Manage dispatch trips for dispatcher training practice.</div>
                        </div>
                        <div class="flex items-center gap10">
                            <a href="{{ route('dispatches.index', ['filter' => 'my']) }}" class="tf-button"
                                style="{{ request('filter') === 'my' ? 'background:#1f2937; color:#fff;' : '' }} text-decoration: none;">My
                                Dispatches</a>
                            <a href="{{ route('dispatches.create') }}" class="tf-button"
                                style="background: #FF5200; color: #fff; text-decoration: none;"><i class="icon-plus"></i> Add Dispatch</a>
                        </div>
                    </div>

                    {{-- Search Filter --}}
                    <div class="wg-box mb-20">
                        <form method="GET" action="{{ route('dispatches.index') }}">
                            @if (request('filter') === 'my')
                                <input type="hidden" name="filter" value="my">
                            @endif
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="body-title mb-10 d-block">Search Trip / Driver / Truck</label>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Trip name, driver, truck"
                                        class="form-control">
                                </div>
                                <div class="col-md-6 mb-3 d-flex align-items-end gap10">
                                    <button type="submit" class="tf-button" style="background:#1f2937; color:#fff;">Search</button>
                                    <a href="{{ route('dispatches.index', request('filter') === 'my' ? ['filter' => 'my'] : []) }}"
                                        class="tf-button" style="text-decoration: none;">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 mb-20">
                            <h4>Saved Dispatches</h4>
                            <span class="text-tiny">{{ $dispatches->total() }} Records</span>
                        </div>

                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items: center;">
                                <li style="flex: 3;">
                                    <div class="body-title">Trip</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Driver</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Truck / Trailer</div>
                                </li>
                                <li style="flex: 1;">
                                    <div class="body-title">Miles</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Invoice Total</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Owner</div>
                                </li>
                                <li style="flex: 2;">
                                    <div class="body-title">Actions</div>
                                </li>
                            </ul>

                            <ul class="flex flex-column">
                                @forelse($dispatches as $dispatch)
                                    <li class="wg-product item-row gap20" style="align-items: center;">
                                        {{-- Trip --}}
                                        <div class="body-text" style="flex: 3; font-weight: bold;">
                                            {{ $dispatch->trip_name }}
                                            <div class="text-tiny">Customer: {{ $dispatch->customer?->name ?? '-' }}</div>
                                        </div>

                                        {{-- Driver --}}
                                        <div class="body-text" style="flex: 2;">
                                            {{ $dispatch->driver?->first_name }} {{ $dispatch->driver?->last_name }}
                                            <div class="text-tiny">Team: {{ $dispatch->teamMembers->count() }} member(s)</div>
                                        </div>

                                        {{-- Truck / Trailer --}}
                                        <div class="body-text" style="flex: 2;">
                                            {{ $dispatch->truck?->unit_number ?? '-' }}
                                            <div class="text-tiny">Trailer: {{ $dispatch->trailer?->trailer_number ?? '-' }}</div>
                                        </div>

                                        {{-- Miles --}}
                                        <div class="body-text" style="flex: 1;">{{ number_format($dispatch->total_miles ?? 0, 2) }}</div>

                                        {{-- Invoice Total --}}
                                        <div class="body-text" style="flex: 2; font-weight: bold; color: #FF5200;">
                                            ${{ number_format($dispatch->invoice_total ?? 0, 2) }}
                                        </div>

                                        {{-- Owner --}}
                                        <div class="body-text" style="flex: 2;">
                                            {{ $dispatch->user?->name ?? 'Unknown' }}
                                            @if (auth()->id() === $dispatch->user_id)
                                                <div class="text-tiny" style="color: #28a745;">Your dispatch</div>
                                            @else
                                                <div class="text-tiny" style="color: #6b7280;">Other dispatcher</div>
                                            @endif
                                        </div>

                                        {{-- Actions --}}
                                        <div class="list-icon-function" style="flex: 2; display: flex; gap: 10px; align-items: center;">
                                            <a href="{{ route('dispatches.show', $dispatch->id) }}" class="item eye" style="text-decoration: none;">
                                                <i class="icon-eye"></i>
                                            </a>
                                            @if (auth()->id() === $dispatch->user_id)
                                                <a href="{{ route('dispatches.edit', $dispatch->id) }}" class="item edit"
                                                    style="text-decoration: none;">
                                                    <i class="icon-edit-3"></i>
                                                </a>
                                                <form action="{{ route('dispatches.destroy', $dispatch->id) }}" method="POST" class="delete-form"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="item trash"
                                                        style="background: none; border: none; cursor: pointer; color: #dc3545;">
                                                        <i class="icon-trash-2"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center" style="padding: 20px; width: 100%; color: red;">No dispatches found.</li>
                                @endforelse
                            </ul>
                        </div>

                        {{-- Pagination --}}
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10">
                            <div class="text-tiny text-surface-2">Showing {{ $dispatches->firstItem() ?? 0 }} to
                                {{ $dispatches->lastItem() ?? 0 }} of {{ $dispatches->total() }} entries</div>
                            {{ $dispatches->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Delete Confirmation (Inline) --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.delete-form').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "This dispatch will be permanently deleted!",
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