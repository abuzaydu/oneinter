@extends('admin.layout')

@section('title', 'Edit Car')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit Car</h5>
            </div>
            <div class="card-body">
                @if(!Auth::user()->can('edit_cars'))
                    <div class="alert alert-warning">
                        <strong>Read-only Mode:</strong> You don't have permission to edit cars. You can view the information but cannot make changes.
                    </div>
                @endif

                <form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Car Name</label>
                                <select class="form-select @error('name') is-invalid @enderror" 
                                        id="name" name="name" 
                                        {{ !Auth::user()->can('edit_cars') ? 'disabled' : '' }} required>
                                    <option value="">Select Car Name</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}" 
                                                {{ old('name', $car->name) == $category->name ? 'selected' : '' }}>
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
                                       id="plate_number" name="plate_number" 
                                       value="{{ old('plate_number', $car->plate_number) }}" 
                                       {{ !Auth::user()->can('edit_cars') ? 'readonly' : '' }} required>
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
                                       id="color" name="color" 
                                       value="{{ old('color', $car->color) }}" 
                                       {{ !Auth::user()->can('edit_cars') ? 'readonly' : '' }} required>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="chassis_number" class="form-label">Chassis Number</label>
                                <input type="text" class="form-control @error('chassis_number') is-invalid @enderror" 
                                       id="chassis_number" name="chassis_number" 
                                       value="{{ old('chassis_number', $car->chassis_number) }}" 
                                       {{ !Auth::user()->can('edit_cars') ? 'readonly' : '' }} required>
                                @error('chassis_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        @if(Auth::user()->can('edit_cars'))
                        <button type="submit" class="btn btn-primary">Update Car</button>
                        @endif
                        <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 