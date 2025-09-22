@extends('admin.layout')

@section('title', 'Edit Driver')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Edit Driver</h5>
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
            <div class="card-body">
                @if(!Auth::user()->can('edit_drivers'))
                    <div class="alert alert-warning">
                        <strong>Read-only Mode:</strong> You don't have permission to edit drivers. You can view the information but cannot make changes.
                    </div>
                @endif

                <form action="{{ route('admin.drivers.update', $driver) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $driver->name) }}" 
                                       {{ !Auth::user()->can('edit_drivers') ? 'readonly' : '' }} required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" name="phone_number" value="{{ old('phone_number', $driver->phone_number) }}" 
                                       {{ !Auth::user()->can('edit_drivers') ? 'readonly' : '' }} required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $driver->email) }}"
                                       {{ !Auth::user()->can('edit_drivers') ? 'readonly' : '' }}>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-select @error('is_active') is-invalid @enderror" 
                                        id="is_active" name="is_active"
                                        {{ !Auth::user()->can('edit_drivers') ? 'disabled' : '' }}>
                                    <option value="1" {{ old('is_active', $driver->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $driver->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="is_available" class="form-label">Availability</label>
                                <select class="form-select @error('is_available') is-invalid @enderror" 
                                        id="is_available" name="is_available"
                                        {{ !Auth::user()->can('edit_drivers') ? 'disabled' : '' }}>
                                    <option value="1" {{ old('is_available', $driver->is_available) == 1 ? 'selected' : '' }}>Available</option>
                                    <option value="0" {{ old('is_available', $driver->is_available) == 0 ? 'selected' : '' }}>Assigned</option>
                                </select>
                                @error('is_available')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        @if(Auth::user()->can('edit_drivers'))
                        <button type="submit" class="btn btn-primary">Update Driver</button>
                        @endif
                        <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 