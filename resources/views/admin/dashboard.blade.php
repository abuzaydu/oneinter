@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card text-center mb-4">
            <div class="card-body">
                <h6 class="mb-2">Completed Bookings</h6>
                <h2>{{ $completedBookings }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center mb-4">
            <div class="card-body">
                <h6 class="mb-2">Ongoing Bookings</h6>
                <h2>{{ $takenBookings }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center mb-4">
            <div class="card-body">
                <h6 class="mb-2">Total Cars</h6>
                <h2>{{ $totalCars }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center mb-4">
            <div class="card-body">
                <h6 class="mb-2">Total Drivers</h6>
                <h2>{{ $totalDrivers }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Completed Bookings Per Month (Last 12 Months)</h5>
            </div>
            <div class="card-body">
                <canvas id="completedBookingsChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxCompleted = document.getElementById('completedBookingsChart').getContext('2d');
    const completedBookingsChart = new Chart(ctxCompleted, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($completedPerMonth->toArray())) !!},
            datasets: [{
                label: 'Completed Bookings',
                data: {!! json_encode(array_values($completedPerMonth->toArray())) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.6)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endpush 