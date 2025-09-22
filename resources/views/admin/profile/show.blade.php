@extends('admin.layout')

@section('title', 'Profile')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <img src="{{ $admin->profile_picture_url }}" 
                         alt="Profile Picture" 
                         class="rounded-circle" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <h5 class="card-title">{{ $admin->name }}</h5>
                <p class="text-muted">{{ $admin->email }}</p>
                <p class="text-muted">{{ $admin->role->name ?? 'Admin' }}</p>
                
                <!-- Profile Picture Upload -->
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadPictureModal">
                        <i class="fas fa-camera"></i> Change Picture
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Profile Information</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="{{ $admin->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $admin->email }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="{{ $admin->role->name ?? 'Admin' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Member Since</label>
                            <input type="text" class="form-control" value="{{ $admin->created_at->format('F d, Y') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Picture Modal -->
<div class="modal fade" id="uploadPictureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.profile.update-picture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Select Image</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" required>
                        <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</div>
                    </div>
                    <div class="mb-3">
                        <img id="imagePreview" src="#" alt="Preview" style="max-width: 100%; max-height: 200px; display: none;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload Picture</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.profile.change-password') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('profile_picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>

@endsection 