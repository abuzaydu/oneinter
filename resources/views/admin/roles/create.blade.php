@extends('admin.layout')

@section('title', 'Add New Role')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Add New Role</h5>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Description </label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror" 
                                       id="email" name="description" value="{{ old('description') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Permissions</label>
                            <div class="row g-3 mt-0"  style="page-break-inside:auto" data-masonry='{"percentPosition": true }'>
                                @foreach ($permissions as $pkey => $value)
                                    <label class="col-sm-3" style="padding-bottom: 5px; page-break-inside:avoid; page-break-after:auto; font-weight: normal;">{{ html()->checkbox('permission[]')->value($value->name)->checked(in_array($value->id, $currPermissions)) }}
                                        {{ $value->name }}</label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->can('create_roles'))
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Create role</button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    @else
                        <div class="mt-4">
                            <div class="alert alert-warning">
                                <strong>Access Denied:</strong> You don't have permission to create roles.
                            </div>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back to List</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 