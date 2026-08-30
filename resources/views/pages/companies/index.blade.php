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
                            <h3>Company List</h3>
                            <div class="text-tiny">Manage saved company records for dispatcher training practice.</div>
                        </div>
                        <div class="flex items-center gap10">
                            <a href="{{ route('companies.index', ['filter' => 'my']) }}" class="tf-button" style="{{ request('filter') === 'my' ? 'background:#1f2937; color:#fff;' : '' }} text-decoration: none;">My Companies</a>
                            <a href="{{ route('companies.create') }}" class="tf-button" style="background: #FF5200; color: #fff; text-decoration: none;"><i class="icon-plus"></i> Add Company</a>
                        </div>
                    </div>

                    {{-- Filters --}}
                    <div class="wg-box mb-20">
                        <form method="GET" action="{{ route('companies.index') }}">
                            @if (request('filter') === 'my')
                                <input type="hidden" name="filter" value="my">
                            @endif
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="body-title mb-10 d-block">Search Name / Phone</label>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Company name or phone" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="body-title mb-10 d-block">Country</label>
                                    <select name="country_id" id="country_id" class="select">
                                        <option value="">All Countries</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @selected(request('country_id') == $country->id)>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="body-title mb-10 d-block">State</label>
                                    <select name="state_id" id="state_id" class="select">
                                        <option value="">All States</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}" @selected(request('state_id') == $state->id)>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="body-title mb-10 d-block">City</label>
                                    <select name="city_id" id="city_id" class="select">
                                        <option value="">All Cities</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @selected(request('city_id') == $city->id)>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3 d-flex gap10">
                                    <button type="submit" class="tf-button" style="background:#1f2937; color:#fff;">Search</button>
                                    <a href="{{ route('companies.index', request('filter') === 'my' ? ['filter' => 'my'] : []) }}" class="tf-button" style="text-decoration: none;">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Table --}}
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 mb-20">
                            <h4>Saved Companies</h4>
                            <span class="text-tiny">{{ $companies->total() }} Records</span>
                        </div>

                        <div class="wg-table table-all-user">
                            <ul class="table-title bg-dark-1 flex gap20 mb-14" style="align-items: center;">
                                <li style="flex: 3;"><div class="body-title">Company</div></li>
                                <li style="flex: 3;"><div class="body-title">Location</div></li>
                                <li style="flex: 2;"><div class="body-title">Phone</div></li>
                                <li style="flex: 3;"><div class="body-title">Email</div></li>
                                <li style="flex: 2;"><div class="body-title">Owner</div></li>
                                <li style="flex: 2;"><div class="body-title">Actions</div></li>
                            </ul>

                            <ul class="flex flex-column">
                                @forelse($companies as $company)
                                    <li class="wg-product item-row gap20" style="align-items: center;">
                                        <div class="body-text" style="flex: 3; font-weight: bold;">
                                            {{ $company->name }}
                                            <div class="text-tiny">MC: {{ $company->motor_carrier_number ?? '-' }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 3;">
                                            {{ $company->city?->name }}, {{ $company->state?->name }}
                                            <div class="text-tiny">{{ $company->country?->name }}</div>
                                        </div>
                                        <div class="body-text" style="flex: 2;">{{ $company->phone_number ?? '-' }}</div>
                                        <div class="body-text" style="flex: 3;">{{ $company->email ?? '-' }}</div>
                                        <div class="body-text" style="flex: 2;">
                                            {{ $company->user?->name ?? 'Unknown' }}
                                            @if (auth()->id() === $company->user_id)
                                                <div class="text-tiny" style="color: #28a745;">Your company</div>
                                            @else
                                                <div class="text-tiny" style="color: #6b7280;">Other dispatcher</div>
                                            @endif
                                        </div>
                                        <div class="list-icon-function" style="flex: 2; display: flex; gap: 10px; align-items: center;">
                                            <a href="{{ route('companies.show', $company->id) }}" class="item eye" style="text-decoration: none;">
                                                <i class="icon-eye"></i>
                                            </a>
                                            @if (auth()->id() === $company->user_id)
                                                <a href="{{ route('companies.edit', $company->id) }}" class="item edit" style="text-decoration: none;">
                                                    <i class="icon-edit-3"></i>
                                                </a>
                                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="delete-form" style="display: inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="item trash" style="background: none; border: none; cursor: pointer; color: #dc3545;">
                                                        <i class="icon-trash-2"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-center" style="padding: 20px; width: 100%; color: red;">No companies found.</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10">
                            <div class="text-tiny text-surface-2">Showing {{ $companies->firstItem() ?? 0 }} to {{ $companies->lastItem() ?? 0 }} of {{ $companies->total() }} entries</div>
                            {{ $companies->links() }}
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
                                text: "This company will be permanently deleted!",
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

            {{-- Cascading filters (Country -> State -> City) --}}
            @include('pages.drivers.partials.location-script')
        </div>
    </div>
@endsection