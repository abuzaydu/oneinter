@extends('admin.layout')

@section('title', 'Booking Details')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Booking Details - {{ $booking->reference_number }}</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-3">Customer Information</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered responsive-table">
                                <tr>
                                    <th>Reference Number</th>
                                    <td><strong>{{ $booking->reference_number }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $booking->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $booking->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $booking->customer_phone }}</td>
                                </tr>
                                <tr>
                                    <th>Organization</th>
                                    <td>{{ $booking->organization ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>ID Type</th>
                                    <td>{{ ucfirst($booking->id_type) }}</td>
                                </tr>
                                <tr>
                                    <th>ID Number</th>
                                    <td>{{ $booking->id_number }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6 class="mb-3">Booking Information</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered responsive-table">
                                <tr>
                                    <th>Car</th>
                                    <td>
                                        @if($booking->car)
                                            {{ $booking->car->name }} ({{ $booking->car->plate_number }})
                                        @elseif($booking->category)
                                            {{ $booking->category->name }} (Category - No specific car assigned yet)
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Preferred Color</th>
                                    <td>{{ $booking->color ?? 'No preference' }}</td>
                                </tr>
                                <!-- <tr>
                                    <th>Organization</th>
                                    <td>{{ $booking->organization ?? 'N/A' }}</td>
                                </tr> -->
                               
                               
                                <tr>
                                    <th>Driver</th>
                                    <td>
                                        @if($booking->driver)
                                            {{ $booking->driver->name }} ({{ $booking->driver->phone_number }})
                                        @else
                                            No driver assigned
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pickup Location</th>
                                    <td>{{ $booking->pickup_location }}</td>
                                </tr>
                                <tr>
                                    <th>Destination</th>
                                    <td>{{ ucfirst($booking->destination) }}</td>
                                </tr>
                                @if($booking->region)
                                <tr>
                                    <th>Region</th>
                                    <td>{{ $booking->region }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Pickup Date & Time</th>
                                    <td>{{ $booking->pickup_date->format('M d, Y g:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Return Date & Time</th>
                                    <td>{{ $booking->return_date->format('M d, Y g:i A') }}</td>
                                </tr>
                                <!-- <tr>
                                    <th>Total Amount</th>
                                    <td>Tsh{{ number_format($booking->total_amount, 2) }}</td>
                                </tr> -->
                                <!-- <tr>
                                    <th>Status</th>
                                    <td>
                                        @if(Auth::user()->can('edit_bookings'))
                                        <form action="{{ route('admin.bookings.update-status', $booking) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm d-inline-block w-auto" 
                                                    onchange="this.form.submit()">
                                                <option value="pending" {{ $booking->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $booking->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="taken" {{ $booking->status === 'taken' ? 'selected' : '' }}>Taken</option>
                                                <option value="completed" {{ $booking->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </form>
                                        @else
                                            <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : 
                                                ($booking->status === 'confirmed' ? 'info' : 
                                                ($booking->status === 'taken' ? 'primary' :
                                                ($booking->status === 'cancelled' ? 'danger' : 'success'))) }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr> -->
                            </table>
                        </div>
                    </div>
                </div>

                @if($booking->special_requests)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Special Requests</h6>
                            <div class="card">
                                <div class="card-body">
                                    {{ $booking->special_requests }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($booking->status === 'taken')
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6>Trip Management Options:</h6>
                                <ul class="mb-0">
                                    <li><strong>Extend Trip:</strong> Extend the return date and update the total amount</li>
                                    <li><strong>Return & Complete:</strong> Returns the car and driver, marks booking as completed</li>
                                    <li><strong>Return Only:</strong> Returns the car and driver, keeps booking active for reassignment</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if(Auth::user()->canAny(['edit_bookings', 'delete_bookings']))
                <div class="row mt-4">
                    <div class="col-12">
                        @if(Auth::user()->can('edit_bookings'))
                            @if(!$booking->car_id)
                                <a href="{{ route('admin.bookings.checkout', $booking) }}" 
                                   class="btn btn-success">Checkout (Assign Car & Driver)</a>
                            @elseif($booking->status === 'taken')
                                <a href="{{ route('admin.bookings.extend-trip', $booking) }}" 
                                   class="btn btn-info">Extend Trip</a>
                                <form action="{{ route('admin.bookings.return-car', $booking) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to return this car and driver? This will mark the booking as completed.');">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Return Car</button>
                                </form>
                            @endif
                        @endif
                        @if(Auth::user()->can('delete_bookings'))
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete Booking</button>
                        </form>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.table-responsive {
    overflow-x: auto;
    min-height: 0%;
}

.responsive-table {
    width: 100%;
    table-layout: fixed;
}

.responsive-table th {
    width: 40%;
    background-color: #f8f9fa;
    font-weight: 600;
    padding: 12px 8px;
    vertical-align: top;
    border: 1px solid #dee2e6;
}

.responsive-table td {
    width: 60%;
    padding: 12px 8px;
    border: 1px solid #dee2e6;
    word-wrap: break-word;
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

/* Force text to wrap and stay within cells */
.responsive-table th,
.responsive-table td {
    white-space: normal;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Ensure long words break properly */
.responsive-table td {
    max-width: 0;
    min-width: 0;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .responsive-table th,
    .responsive-table td {
        padding: 8px 6px;
        font-size: 14px;
    }
    
    .col-md-6 {
        margin-bottom: 20px;
    }
    
    .responsive-table th {
        width: 35%;
    }
    
    .responsive-table td {
        width: 65%;
    }
}

@media (max-width: 576px) {
    .responsive-table th,
    .responsive-table td {
        padding: 6px 4px;
        font-size: 13px;
    }
    
    .responsive-table th {
        width: 30%;
    }
    
    .responsive-table td {
        width: 70%;
    }
}
</style>
@endsection 