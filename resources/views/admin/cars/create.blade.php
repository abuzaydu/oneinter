@extends('admin.layout')

@section('title', 'Add New Car')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Add New Car</h5>
            </div>
            <div class="card-body">
                @if(!Auth::user()->can('create_cars'))
                    <div class="alert alert-danger">
                        <strong>Access Denied:</strong> You don't have permission to create new cars.
                    </div>
                @else
                <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Car Name</label>
                                <select class="form-select @error('name') is-invalid @enderror" 
                                        id="name" name="name" required>
                                    <option value="">Select Car Name</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}" 
                                                {{ old('name') == $category->name ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="plate_number" class="form-label">Plate Number</label>
                                <input type="text" class="form-control @error('plate_number') is-invalid @enderror" 
                                       id="plate_number" name="plate_number" value="{{ old('plate_number') }}" required>
                                @error('plate_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="color" class="form-label">Color</label>
                                <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                       id="color" name="color" value="{{ old('color') }}" required>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="chassis_number" class="form-label">Chassis Number</label>
                                <input type="text" class="form-control @error('chassis_number') is-invalid @enderror" 
                                       id="chassis_number" name="chassis_number" value="{{ old('chassis_number') }}" required>
                                @error('chassis_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Add Car</button>
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 