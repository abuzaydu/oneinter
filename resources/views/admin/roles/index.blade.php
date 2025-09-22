@extends('admin.layout')

@section('title', 'Roles')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Roles</h5>
                @if(Auth::user()->can('create_roles'))
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Add New Role</a>
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
                                <th>Description</th>
                                <th>Users</th>
                                <th>Permissions</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description ?? 'N/A' }}</td>
                                    <td><span class="badge bg-info">{{ $role->users_count }}</span></td>
                                    <td><span class="badge bg-danger">{{ $role->permissions_count }}</span></td>
                                    <td>{{ $role->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @if(Auth::user()->can('edit_roles'))
                                            <a href="{{ route('admin.roles.edit', encrypt($role->id)) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @endif
                                        
                                        @if(Auth::user()->can('delete_roles'))
                                            <form action="{{ route('admin.roles.destroy', encrypt($role->id)) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No roles found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 