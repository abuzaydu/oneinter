@extends('admin.layout')

@section('title', 'Drivers')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Drivers</h5>
                @if(Auth::user()->can('create_drivers'))
                <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary">Add New Driver</a>
                @endif
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Availability</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($drivers as $driver)
                                <tr>
                                    <td>{{ $driver->id }}</td>
                                    <td>{{ $driver->name }}</td>
                                    <td>{{ $driver->phone_number }}</td>
                                    <td>{{ $driver->email ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $driver->is_active ? 'success' : 'danger' }}">
                                            {{ $driver->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $driver->is_available ? 'success' : 'warning' }}">
                                            {{ $driver->is_available ? 'Available' : 'Assigned' }}
                                        </span>
                                    </td>
                                    <td>{{ $driver->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.drivers.show', $driver) }}" 
                                           class="btn btn-sm btn-info">View</a>
                                        @if(Auth::user()->can('edit_drivers'))
                                        <a href="{{ route('admin.drivers.edit', $driver) }}" 
                                           class="btn btn-sm btn-warning">Edit</a>
                                        @endif
                                        @if(Auth::user()->can('delete_drivers'))
                                        <form action="{{ route('admin.drivers.destroy', $driver) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this driver?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No drivers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $drivers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 