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
                    {{-- Header with All/My Drivers --}}
                    <div class="flex items-center flex-wrap justify-between gap20 mb-30">
                        <div>
                            <h3>Driver List</h3>
                            <div class="text-tiny">Manage driver records for dispatcher training practice.</div>
                        </div>
                        <div class="flex items-center gap10">
                            <a href="{{ route('drivers.index') }}" class="tf-button" style="{{ request('filter') !== 'my' ? 'background:#1f2937; color:#fff;' : '' }} text-decoration: none;">All Drivers</a>
                            <a href="{{ route('drivers.index', ['filter' => 'my']) }}" class="tf-button" style="{{ request('filter') === 'my' ? 'background:#1f2937; color:#fff;' : '' }} text-decoration: none;">My Drivers</a>
                            <a href="{{ route('drivers.create') }}" class="tf-button" style="background: #FF5200; color: #fff; text-decoration: none;"><i class="icon-plus"></i> Add Driver</a>
                        </div>
                    </div>

                    {{-- Filters --}}
                    <div class="wg-box mb-20">
                        <form method="GET" action="{{ route('drivers.index') }}">
                            @if (request('filter') === 'my')
                                <input type="hidden" name="filter" value="my">
                            @endif
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">Search Name / Phone / License</label>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, phone, license" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">Country</label>
                                    <select name="country_id" id="country_id" class="select">
                                        <option value="">All Countries</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @selected(request('country_id') == $country->id)>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">State</label>
                                    <select name="state_id" id="state_id" class="select">
                                        <option value="">All States</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}" @selected(request('state_id') == $state->id)>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">City</label>
                                    <select name="city_id" id="city_id" class="select">
                                        <option value="">All Cities</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">Payment Type</label>
                                    <select name="payment_type" class="select">
                                        <option value="">All Payment Types</option>
                                        @foreach ($paymentTypes as $type)
                                            <option value="{{ $type }}" @selected(request('payment_type') == $type)>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3 d-flex align-items-end gap10">
                                    <button type="submit" class="tf-button" style="background:#1f2937; color:#fff;">Search</button>
                                    <a href="{{ route('drivers.index', request('filter') === 'my' ? ['filter' => 'my'] : []) }}" class="tf-button" style="text-decoration: none;">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 mb-20">
                            <h4>Saved Drivers</h4>
                            <span class="text-tiny">{{ $drivers->total() }} Records</span>
                        </div>

                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items: center;">
                                <li style="flex: 2;"><div class="body-title">Driver</div></li>
                                <li style="flex: 3;"><div class="body-title">Location</div></li>
                                <li style="flex: 2;"><div class="body-title">Phone</div></li>
                                <li style="flex: 2;"><div class="body-title">Payment Type</div></li>
                                <li style="flex: 2;"><div class="body-title">License</div></li>
                                <li style="flex: 2;"><div class="body-title">Owner</div></li>
                                <li style="flex: 2;"><div class="body-title">Actions</div></li>
                            </ul>

                            <ul class="flex flex-column">
                                @forelse($drivers as $driver)
                                    <li class="wg-product item-row gap20" style="align-items: center;">
                                        <div class="body-text" style="flex: 2; font-weight: bold;">
                                            {{ $driver->first_name }} {{ $driver->last_name }}
                                            <div class="text-tiny">{{ $driver->email ?? '-' }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 3;">
                                            {{ $driver->city?->name }}, {{ $driver->state?->name }}
                                            <div class="text-tiny">{{ $driver->country?->name }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 2;">{{ $driver->phone ?? 'N/A' }}</div>
                                        <div class="body-text" style="flex: 2;">{{ $driver->payment_type }}</div>
                                        <div class="body-text" style="flex: 2;">
                                            {{ $driver->license_number }}
                                            <div class="text-tiny">Exp: {{ $driver->license_expiration?->format('d-m-Y') ?? '-' }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 2;">
                                            {{ $driver->user?->name ?? 'Unknown' }}
                                            @if (auth()->id() === $driver->user_id)
                                                <div class="text-tiny" style="color: #28a745;">Your driver</div>
                                            @else
                                                <div class="text-tiny" style="color: #6b7280;">Other dispatcher</div>
                                            @endif
                                        </div>
                                        <div class="list-icon-function" style="flex: 2; display: flex; gap: 10px; align-items: center;">
                                            {{-- View: Sab ko allowed --}}
                                            <a href="{{ route('drivers.show', $driver->id) }}" class="item eye" style="text-decoration: none;">
                                                <i class="icon-eye"></i>
                                            </a>

                                            {{-- Edit/Delete: Sirf Owner --}}
                                            @if (auth()->id() === $driver->user_id)
                                                <a href="{{ route('drivers.edit', $driver->id) }}" class="item edit" style="text-decoration: none;">
                                                    <i class="icon-edit-3"></i>
                                                </a>
                                                <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" class="delete-form" style="display: inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="item trash" style="background: none; border: none; cursor: pointer; color: #dc3545;">
                                                        <i class="icon-trash-2"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center" style="padding: 20px; width: 100%; color: red;">No drivers found.</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10">
                            <div class="text-tiny text-surface-2">Showing {{ $drivers->firstItem() ?? 0 }} to {{ $drivers->lastItem() ?? 0 }} of {{ $drivers->total() }} entries</div>
                            {{ $drivers->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ✅ INLINE Delete Confirmation Script (yeh @push se zyada reliable hai) --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.delete-form').forEach(function(form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "This driver will be permanently deleted!",
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

            {{-- Cascading Filters Script --}}
            @include('pages.drivers.partials.location-script')
        </div>
    </div>
@endsection