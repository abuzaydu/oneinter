@extends('admin.layout')

@section('title', 'Users')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Users</h5>
                @if(Auth::user()->can('create_users'))
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
                @endif
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

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Email Verified</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>
                                        @if($user->roles()->count() > 0)
                                            <span class="badge bg-info">{{ ucfirst($user->roles[0]['name']) }}</span>
                                        @else
                                            <span class="badge bg-secondary">No Role Assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'warning' }}">
                                            {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if(Auth::user()->can('view_users'))
                                            <a href="{{ route('admin.users.show', $user) }}" 
                                               class="btn btn-sm btn-info">View</a>
                                        @endif
                                        
                                        @if(Auth::user()->can('edit_users'))
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.users.send-password-reset', $user) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-secondary" 
                                                        onclick="return confirm('Send password reset email to this user?')">
                                                    Reset Password
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(Auth::user()->can('delete_users'))
                                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 