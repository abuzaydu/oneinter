@extends('admin.layout')

@section('title', 'Checkout Booking')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Checkout Booking - {{ $booking->reference_number }}</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
            <div class="card-body">
                @if(!Auth::user()->can('edit_bookings'))
                    <div class="alert alert-danger">
                        <strong>Access Denied:</strong> You don't have permission to checkout bookings.
                    </div>
                @else
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-3">Booking Information</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th>Reference Number</th>
                                <td><strong>{{ $booking->reference_number }}</strong></td>
                            </tr>
                            <tr>
                                <th>Customer</th>
                                <td>{{ $booking->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $booking->customer_phone }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $booking->customer_email }}</td>
                            </tr>
                            <tr>
                                <th>Pickup Location</th>
                                <td>{{ $booking->pickup_location }}</td>
                            </tr>
                            <tr>
                                <th>Destination</th>
                                <td>{{ ucfirst($booking->destination) }}
                                    @if($booking->region)
                                        - {{ $booking->region }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                                                    <th>Pickup Date & Time</th>
                                                                    <td>{{ $booking->pickup_date->format('M d, Y g:i A') }}</td>
                            </tr>
                            <tr>
                                                                    <th>Return Date & Time</th>
                                                                    <td>{{ $booking->return_date->format('M d, Y g:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Total Amount</th>
                                <td>${{ number_format($booking->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>
                                    @if($booking->category)
                                        {{ $booking->category->name }}<br>
                                        <small class="text-muted">
                                            Daily Rate: ${{ number_format($booking->category->daily_rate, 2) }} | 
                                            Seats: {{ $booking->category->seats ?? 'N/A' }}
                                        </small>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="mb-3">Assign Car & Driver</h6>
                        <form action="{{ route('admin.bookings.process-checkout', $booking) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="car_id" class="form-label">Select Car <span class="text-danger">*</span></label>
                                <div class="alert alert-info mb-2">
                                    <strong>Category:</strong> {{ $booking->category->name ?? 'N/A' }}<br>
                                    <small>Only cars from this category are available for selection.</small><br>
                                    <small><strong>Available cars in this category:</strong> {{ $availableCars->count() }}</small>
                                </div>
                                <select class="form-select @error('car_id') is-invalid @enderror" 
                                        id="car_id" name="car_id" required>
                                    <option value="">Choose a car...</option>
                                    @foreach($availableCars as $car)
                                        <option value="{{ $car->id }}" 
                                                {{ old('car_id') == $car->id ? 'selected' : '' }}>
                                            {{ $car->name }} - {{ $car->plate_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('car_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($availableCars->count() == 0)
                                    <div class="text-danger mt-1">
                                        No available cars found in category "{{ $booking->category->name ?? 'N/A' }}". 
                                        Please add cars to this category or check availability.
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="driver_id" class="form-label">Select Driver <span class="text-danger">*</span></label>
                                <div class="alert alert-info mb-2">
                                    <strong>Available Drivers:</strong> {{ $availableDrivers->count() }}
                                </div>
                                <select class="form-select @error('driver_id') is-invalid @enderror" 
                                        id="driver_id" name="driver_id" required>
                                    <option value="">Choose a driver...</option>
                                    @foreach($availableDrivers as $driver)
                                        <option value="{{ $driver->id }}" 
                                                {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                            {{ $driver->name }} - {{ $driver->phone_number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('driver_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($availableDrivers->count() == 0)
                                    <div class="text-danger mt-1">
                                        No available drivers found. Please add drivers or check availability.
                                    </div>
                                @endif
                            </div>

                            <div class="alert alert-info">
                                <strong>Note:</strong> After checkout, the car will be marked as unavailable and the booking status will be changed to "taken".
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary" 
                                        {{ $availableCars->count() == 0 || $availableDrivers->count() == 0 ? 'disabled' : '' }}>
                                    Complete Checkout
                                </button>
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 