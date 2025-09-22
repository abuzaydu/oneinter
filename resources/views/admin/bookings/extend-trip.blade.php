@extends('admin.layout')

@section('title', 'Extend Trip')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Extend Trip - {{ $booking->reference_number }}</h5>
                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-secondary">Back to Booking</a>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Current Booking Details</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th>Customer</th>
                                <td>{{ $booking->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Car</th>
                                <td>
                                    @if($booking->car)
                                        {{ $booking->car->name }} ({{ $booking->car->plate_number }})
                                    @elseif($booking->category)
                                        {{ $booking->category->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                                                    <th>Current Return Date & Time</th>
                                                                    <td><strong>{{ $booking->return_date->format('M d, Y g:i A') }}</strong></td>
                            </tr>
                            <tr>
                                <th>Current Total Amount</th>
                                <td><strong>${{ number_format($booking->total_amount, 2) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                    <!-- <div class="col-md-6">
                        <h6>Extension Information</h6>
                        <div class="alert alert-info">
                            <ul class="mb-0">
                                <li><strong>Daily Rate:</strong> 
                                    @if($booking->car && $booking->car->category)
                                        ${{ number_format($booking->car->category->daily_rate, 2) }}
                                    @elseif($booking->category)
                                        ${{ number_format($booking->category->daily_rate, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </li>
                                <li><strong>Extension:</strong> Additional days will be calculated from the current return date</li>
                                <li><strong>Total Amount:</strong> Will be updated to include the extension cost</li>
                            </ul>
                        </div>
                    </div> -->
                </div>

                <form action="{{ route('admin.bookings.process-extend-trip', $booking) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="new_return_date" class="form-label">New Return Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('new_return_date') is-invalid @enderror" 
                                       id="new_return_date" 
                                       name="new_return_date" 
                                       value="{{ old('new_return_date') }}"
                                       min="{{ $booking->return_date->addDay()->format('Y-m-d') }}"
                                       required>
                                @error('new_return_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Must be after the current return date ({{ $booking->return_date->format('M d, Y g:i A') }})
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to extend this trip? This will update the return date and total amount.')">
                                Extend Trip
                            </button>
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newReturnDateInput = document.getElementById('new_return_date');
    const currentReturnDate = '{{ $booking->return_date->format("Y-m-d") }}';
    
    // Set minimum date to one day after current return date
    const minDate = new Date(currentReturnDate);
    minDate.setDate(minDate.getDate() + 1);
    newReturnDateInput.min = minDate.toISOString().split('T')[0];
    
    // Set default value to minimum date if no value is set
    if (!newReturnDateInput.value) {
        newReturnDateInput.value = minDate.toISOString().split('T')[0];
    }
});
</script>
@endsection 