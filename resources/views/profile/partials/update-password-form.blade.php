<div class="mb-4">
    <h5 class="card-title">Update Password</h5>
    <p class="text-muted">Ensure your account is using a long, random password to stay secure.</p>
</div>

<form method="post" action="{{ route('profile.change-password') }}">
    @csrf

    <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
               id="current_password" name="current_password" autocomplete="current-password">
        @error('current_password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input type="password" class="form-control @error('password') is-invalid @enderror" 
               id="password" name="password" autocomplete="new-password">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" 
               id="password_confirmation" name="password_confirmation" autocomplete="new-password">
    </div>

    <div class="d-flex align-items-center gap-2">
        <button type="submit" class="btn btn-warning">Change Password</button>

        @if (session('status') === 'password-updated')
            <span class="text-success">Password updated successfully!</span>
        @endif
    </div>
</form>
