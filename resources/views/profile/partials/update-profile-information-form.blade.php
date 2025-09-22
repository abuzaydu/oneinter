<div class="mb-4">
    <h5 class="card-title">Profile Information</h5>
    <p class="text-muted">Update your account's profile information and email address.</p>
</div>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" 
               id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" 
               id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex align-items-center gap-2">
        <button type="submit" class="btn btn-primary">Save</button>

        @if (session('status') === 'profile-updated')
            <span class="text-success">Profile updated successfully!</span>
        @endif
    </div>
</form>
