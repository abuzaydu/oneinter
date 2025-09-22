@extends('admin.layout')

@section('title', 'Create New Booking')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Create New Booking</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to Bookings</a>
            </div>
            <div class="card-body">
                @if(!Auth::user()->can('create_bookings'))
                    <div class="alert alert-danger">
                        <strong>Access Denied:</strong> You don't have permission to create new bookings.
                    </div>
                @else
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.bookings.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <!-- Car Selection -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Car Selection</h6>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Car Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select a Car Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                data-daily-rate="{{ $category->daily_rate ?? 0 }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} - Tsh {{ number_format($category->daily_rate ?? 0) }}/day
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Booking Status -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Booking Status</h6>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="taken" {{ old('status') == 'taken' ? 'selected' : '' }}>Taken</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Trip Details -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Trip Details</h6>
                            
                            <div class="mb-3">
                                <label for="pickup_location" class="form-label">Pickup Location</label>
                                <input type="text" name="pickup_location" id="pickup_location" 
                                       class="form-control @error('pickup_location') is-invalid @enderror" 
                                       value="{{ old('pickup_location') }}">
                                @error('pickup_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="destination" class="form-label">Destination <span class="text-danger">*</span></label>
                                <select name="destination" id="destination" class="form-control @error('destination') is-invalid @enderror" required>
                                    <option value="">Select Destination</option>
                                    <option value="within the city" {{ old('destination') == 'within the city' ? 'selected' : '' }}>Within the City</option>
                                    <option value="out of the city" {{ old('destination') == 'out of the city' ? 'selected' : '' }}>Out of the City</option>
                                </select>
                                @error('destination')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="region-container" style="display: none;">
                                <label for="region" class="form-label">Region <span class="text-danger">*</span></label>
                                <input type="text" name="region" id="region" 
                                       class="form-control @error('region') is-invalid @enderror" 
                                       value="{{ old('region') }}">
                                @error('region')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pickup_date" class="form-label">Pickup Date <span class="text-danger">*</span></label>
                                        <div class="row g-2">
                                            <div class="col-8">
                                                <input type="date" name="pickup_date" id="pickup_date" 
                                                       class="form-control @error('pickup_date') is-invalid @enderror" 
                                                       value="{{ old('pickup_date') }}" required>
                                            </div>
                                            <div class="col-4">
                                                <select name="pickup_time" id="pickup_time" class="form-control" required>
                                                    <option value="">Time</option>
                                                    @for($hour = 0; $hour < 24; $hour++)
                                                        @for($minute = 0; $minute < 60; $minute += 30)
                                                            @php
                                                                $time = sprintf('%02d:%02d', $hour, $minute);
                                                                $display_time = date('g:i A', strtotime($time));
                                                            @endphp
                                                            <option value="{{ $time }}" {{ old('pickup_time') == $time ? 'selected' : '' }}>
                                                                {{ $display_time }}
                                                            </option>
                                                        @endfor
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        @error('pickup_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="return_date" class="form-label">Return Date <span class="text-danger">*</span></label>
                                        <div class="row g-2">
                                            <div class="col-8">
                                                <input type="date" name="return_date" id="return_date" 
                                                       class="form-control @error('return_date') is-invalid @enderror" 
                                                       value="{{ old('return_date') }}" required>
                                            </div>
                                            <div class="col-4">
                                                <select name="return_time" id="return_time" class="form-control" required>
                                                    <option value="">Time</option>
                                                    @for($hour = 0; $hour < 24; $hour++)
                                                        @for($minute = 0; $minute < 60; $minute += 30)
                                                            @php
                                                                $time = sprintf('%02d:%02d', $hour, $minute);
                                                                $display_time = date('g:i A', strtotime($time));
                                                            @endphp
                                                            <option value="{{ $time }}" {{ old('return_time') == $time ? 'selected' : '' }}>
                                                                {{ $display_time }}
                                                            </option>
                                                        @endfor
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        @error('return_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Details -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Customer Details</h6>
                            
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" id="customer_name" 
                                       class="form-control @error('customer_name') is-invalid @enderror" 
                                       value="{{ old('customer_name') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Customer Email</label>
                                <input type="email" name="customer_email" id="customer_email" 
                                       class="form-control @error('customer_email') is-invalid @enderror" 
                                       value="{{ old('customer_email') }}">
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Customer Phone <span class="text-danger">*</span></label>
                                <input type="text" name="customer_phone" id="customer_phone" 
                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                       value="{{ old('customer_phone') }}" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nida" class="form-label">NIDA Number <span class="text-danger">*</span></label>
                                <input type="text" name="nida" id="nida" 
                                       class="form-control @error('nida') is-invalid @enderror" 
                                       value="{{ old('nida') }}" required>
                                @error('nida')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="special_requests" class="form-label">Special Requests</label>
                                <textarea name="special_requests" id="special_requests" 
                                          class="form-control @error('special_requests') is-invalid @enderror" 
                                          rows="3" placeholder="Any special requests or notes...">{{ old('special_requests') }}</textarea>
                                @error('special_requests')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>Note:</strong> The total amount will be calculated automatically based on the selected car category and rental duration.
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Create Booking</button>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const destinationSelect = document.getElementById('destination');
    const regionContainer = document.getElementById('region-container');
    const regionInput = document.getElementById('region');
    const pickupDate = document.getElementById('pickup_date');
    const pickupTime = document.getElementById('pickup_time');
    const returnDate = document.getElementById('return_date');
    const returnTime = document.getElementById('return_time');

    destinationSelect.addEventListener('change', function() {
        if (this.value === 'out of the city') {
            regionContainer.style.display = 'block';
            regionInput.required = true;
        } else {
            regionContainer.style.display = 'none';
            regionInput.required = false;
            regionInput.value = '';
        }
    });

    // Set minimum return date based on pickup date
    function updateReturnDateMin() {
        if (pickupDate.value) {
            returnDate.min = pickupDate.value;
            // If return date is before pickup date, reset it
            if (returnDate.value && returnDate.value < pickupDate.value) {
                returnDate.value = pickupDate.value;
            }
        }
    }

    // Set minimum return time based on pickup date and time
    function updateReturnTimeMin() {
        if (pickupDate.value && returnDate.value && pickupTime.value) {
            if (pickupDate.value === returnDate.value) {
                // Same day - return time must be after pickup time
                var pickupDateTime = new Date(pickupDate.value + 'T' + pickupTime.value);
                var returnDateTime = new Date(returnDate.value + 'T' + returnTime.value);
                
                if (returnDateTime <= pickupDateTime) {
                    returnTime.value = '';
                }
            }
        }
    }

    pickupDate.addEventListener('change', updateReturnDateMin);
    pickupTime.addEventListener('change', updateReturnTimeMin);
    returnDate.addEventListener('change', updateReturnTimeMin);

    // Trigger change event on page load if destination is already selected
    if (destinationSelect.value === 'out of the city') {
        regionContainer.style.display = 'block';
        regionInput.required = true;
    }
});
</script>
@endsection 