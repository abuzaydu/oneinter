@extends('admin.layout')

@section('title', 'Driver Details')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Driver Details #{{ $driver->id }}</h5>
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-3">Driver Information</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <td>{{ $driver->id }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $driver->name }}</td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td>{{ $driver->phone_number }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $driver->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-{{ $driver->is_active ? 'success' : 'danger' }}">
                                        {{ $driver->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Availability</th>
                                <td>
                                    <span class="badge bg-{{ $driver->is_available ? 'success' : 'warning' }}">
                                        {{ $driver->is_available ? 'Available' : 'Assigned' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $driver->created_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $driver->updated_at->format('M d, Y H:i:s') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="mb-3">Booking History</h6>
                        @if($driver->bookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($driver->bookings->take(5) as $booking)
                                            <tr>
                                                <td>#{{ $booking->id }}</td>
                                                <td>{{ $booking->customer_name }}</td>
                                                <td>{{ $booking->pickup_date->format('M d, Y g:i A') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : 
                                                        ($booking->status === 'confirmed' ? 'success' : 
                                                        ($booking->status === 'cancelled' ? 'danger' : 'info')) }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($driver->bookings->count() > 5)
                                <p class="text-muted">Showing 5 of {{ $driver->bookings->count() }} bookings</p>
                            @endif
                        @else
                            <p class="text-muted">No bookings found for this driver.</p>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->canAny(['edit_drivers', 'delete_drivers']))
                <div class="row mt-4">
                    <div class="col-12">
                        @if(Auth::user()->can('edit_drivers'))
                        <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-warning">Edit Driver</a>
                        @endif
                        @if(Auth::user()->can('delete_drivers'))
                        <form action="{{ route('admin.drivers.destroy', $driver) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this driver?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Driver</button>
                        </form>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 