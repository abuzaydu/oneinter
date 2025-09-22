<div class="mb-4">
    <h5 class="card-title">Profile Picture</h5>
    <p class="text-muted">Update your profile picture.</p>
</div>

<div class="row">
    <div class="col-md-4">
        <!-- Current Profile Picture -->
        <div class="text-center mb-3">
            <img src="{{ $user->profile_picture_url }}" 
                 alt="Profile Picture" 
                 class="rounded-circle" 
                 style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #dee2e6;">
            <div class="mt-2">
                <h6 class="mb-0">{{ $user->name }}</h6>
                <small class="text-muted">{{ $user->email }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Upload Form -->
        <form method="post" action="{{ route('profile.update-picture') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*" required>
                @error('profile_picture')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div class="form-text">
                    Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button type="submit" class="btn btn-primary">Upload Picture</button>

                @if (session('status') === 'picture-updated')
                    <span class="text-success">Saved successfully!</span>
                @endif
            </div>
        </form>
    </div>
</div> 