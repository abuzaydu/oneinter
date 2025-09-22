@extends('admin.layout')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Edit User</h5>
                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">Back to Details</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role</label>
                                <select class="form-control @error('role_id') is-invalid @enderror" 
                                        id="role_id" name="role_id">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                    @if($user->roles()->count() > 0 && $role->id == $user->roles[0]['id'])
                                    <option value="{{ $role->id }}" selected>{{ ucfirst($role->name) }} - {{ $role->description }}</option>
                                    @else
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }} - {{ $role->description }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>Note:</strong> Password changes are not handled here. Use the "Send Password Reset" button on the user details page to allow the user to reset their password.
                    </div>

                    @if(Auth::user()->can('edit_users'))
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    @else
                        <div class="mt-4">
                            <div class="alert alert-warning">
                                <strong>Read-only Mode:</strong> You don't have permission to edit users.
                            </div>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary">Back to Details</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 