@extends('admin.layout')

@section('title', 'Bookings')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Bookings</h5>
                <div class="d-flex gap-2">
                    @if(auth()->user()->role && auth()->user()->role->name === 'admin')
                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-download"></i> Export Report
                    </button>
                    @endif
                    @if(Auth::user()->can('create_bookings'))
                    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">Add New Booking</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Car</th>
                                <th>Driver</th>
                                <th>Destination</th>
                                <th>Organization</th>
                                <th>Booking Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->reference_number }}</strong><br>
                                        <small class="text-muted">#{{ $booking->id }}</small>
                                    </td>
                                    <td>
                                        {{ $booking->customer_name }}<br>
                                        <small>{{ $booking->customer_email }}</small><br>
                                        <small>{{ $booking->customer_phone }}</small>
                                    </td>
                                    <td>
                                        @if($booking->car)
                                            {{ $booking->car->name }}<br>
                                            <small class="text-muted">{{ $booking->car->plate_number }}</small>
                                        @elseif($booking->category)
                                            {{ $booking->category->name }} (Category)
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($booking->driver)
                                            {{ $booking->driver->name }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if( ucfirst($booking->destination) == 'Out of the city' )
                                        {{ ucfirst($booking->destination) }} - {{ $booking->region }}
                                        @else
                                        {{ ucfirst($booking->destination) }}
                                        @endif

                                    </td>
                                    <td>
                                        {{ $booking->organization ?? 'N/A' }}
                                    </td>
                                    <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : 
                                            ($booking->status === 'confirmed' ? 'info' : 
                                            ($booking->status === 'taken' ? 'primary' :
                                            ($booking->status === 'cancelled' ? 'danger' : 'success'))) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.bookings.show', $booking) }}">
                                                        <i class="fas fa-eye text-info"></i> View
                                                    </a>
                                                </li>
                                                @if(Auth::user()->can('edit_bookings'))
                                                    @if(!$booking->car_id)
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.bookings.checkout', $booking) }}">
                                                                <i class="fas fa-check text-success"></i> Checkout
                                                            </a>
                                                        </li>
                                                    @elseif($booking->status === 'taken')
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.bookings.extend-trip', $booking) }}">
                                                                <i class="fas fa-clock text-info"></i> Extend
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form action="{{ route('admin.bookings.return-car', $booking) }}" 
                                                                  method="POST" 
                                                                  onsubmit="return confirm('Are you sure you want to return this car and driver? This will mark the booking as completed.');">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item text-warning">
                                                                    <i class="fas fa-undo"></i> Return Car
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if(Auth::user()->can('delete_bookings'))
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('admin.bookings.destroy', $booking) }}" 
                                                              method="POST" 
                                                              onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Bookings Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exportForm">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Filter</label>
                        <select class="form-select" id="status" name="status">
                            <option value="all">All Bookings</option>
                            <option value="pending">Pending Only</option>
                            <option value="confirmed">Confirmed Only</option>
                            <option value="taken">Taken Only</option>
                            <option value="completed">Completed Only</option>
                            <option value="cancelled">Cancelled Only</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Export Format</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success flex-fill" onclick="exportReport('excel')">
                                <i class="fas fa-file-excel"></i> Excel
                            </button>
                            <button type="button" class="btn btn-danger flex-fill" onclick="exportReport('pdf')">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function exportReport(format) {
    const status = document.getElementById('status').value;
    const fromDate = document.getElementById('from_date').value;
    const toDate = document.getElementById('to_date').value;
    
    let url = '';
    if (format === 'excel') {
        url = '{{ route("admin.bookings.export-excel") }}';
    } else {
        url = '{{ route("admin.bookings.export-pdf") }}';
    }
    
    // Build query parameters
    const params = new URLSearchParams();
    params.append('status', status);
    if (fromDate) params.append('from_date', fromDate);
    if (toDate) params.append('to_date', toDate);
    
    // Open in new tab
    window.open(url + '?' + params.toString(), '_blank');
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
    modal.hide();
}
</script>

@endsection 