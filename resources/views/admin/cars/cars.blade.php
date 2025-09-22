@extends('admin.layout')

@section('title', 'Cars')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Cars</h5>
                <div class="d-flex gap-2">
                    @if(auth()->user()->role && auth()->user()->role->name === 'admin')
                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-download"></i> Export Report
                    </button>
                    @endif
                    @if(Auth::user()->can('create_cars'))
                    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">Add New Car</a>
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
                                <th>Name</th>
                                <th>Plate Number</th>
                                <th>Color</th>
                                <th>Chassis Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cars as $car)
                                <tr>
                                    <td>
                                        @if($car->picture)
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#pictureModal{{ $car->id }}">{{ $car->name }}</a>
                                        @else
                                            {{ $car->name }}
                                        @endif
                                    </td>
                                    <td>{{ $car->plate_number }}</td>
                                    <td>{{ $car->color ?? 'N/A' }}</td>
                                    <td>{{ $car->chassis_number ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $car->is_available ? 'bg-success' : 'bg-danger' }}">
                                            {{ $car->is_available ? 'Available' : 'Not Available' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(Auth::user()->can('edit_cars'))
                                        <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-info">Edit</a>
                                        @endif
                                        @if(Auth::user()->can('delete_cars'))
                                        <form action="{{ route('admin.cars.destroy', $car) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this car?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No cars found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $cars->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Picture Modals -->
@foreach($cars as $car)
    @if($car->picture)
    <div class="modal fade" id="pictureModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Car Picture – {{ $car->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('storage/' . $car->picture) }}" alt="Car Picture" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Cars Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exportForm">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Filter</label>
                        <select class="form-select" id="status" name="status">
                            <option value="all">All Cars</option>
                            <option value="available">Available Only</option>
                            <option value="unavailable">Unavailable Only</option>
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
        url = '{{ route("admin.cars.export-excel") }}';
    } else {
        url = '{{ route("admin.cars.export-pdf") }}';
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