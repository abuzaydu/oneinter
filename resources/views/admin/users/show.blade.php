@extends('admin.layout')

@section('title', 'User Details')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>User Details</h5>
                <div>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit User</a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-borderless">
                            <tr>
                                <th>Name:</th>
                                <td>{{ $user->name }}</td>
                                <th>Email:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $user->phone ?? 'Not provided' }}</td>
                                <th>Default Pass Key</th>
                                <td>{{ $user->default_pass }}</td>
                            </tr>
                            <tr>
                                <th>Role:</th>
                                <td>
                                    @if($user->roles()->count() > 0)
                                        <span class="badge bg-info">{{ ucfirst($user->roles[0]['name']) }}</span>
                                        <small class="text-muted d-block">{{ $user->roles[0]['description'] }}</small>
                                    @else
                                        <span class="badge bg-secondary">No Role Assigned</span>
                                    @endif
                                </td>
                                <th>Address:</th>
                                <td>{{ $user->address ?? 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <th width="150">Email Verified:</th>
                                <td>
                                    <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                        {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                                    </span>
                                </td>
                                <th>Created At:</th>
                                <td>{{ $user->created_at->format('F d, Y \a\t g:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Updated At:</th>
                                <td>{{ $user->updated_at->format('F d, Y \a\t g:i A') }}</td>
                                <th>Last Login:</th>
                                <td>{{ $user->last_login_at ?? 'Never logged in' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if(Auth::user()->canAny(['edit_users', 'delete_users']))
                    <div class="mt-4">
                        <h6>Actions</h6>
                        <div class="btn-group" role="group">
                            @if(Auth::user()->can('edit_users'))
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2">
                                    <i class="feather icon-edit"></i> Edit User
                                </a>
                                <form action="{{ route('admin.users.send-password-reset', $user) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary me-2" 
                                            onclick="return confirm('Send password reset email to this user?')">
                                        <i class="feather icon-mail"></i> Send Password Reset
                                    </button>
                                </form>
                            @endif
                            
                            @if(Auth::user()->can('delete_users'))
                                <form action="{{ route('admin.users.destroy', $user) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="feather icon-trash-2"></i> Delete User
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 