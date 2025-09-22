@extends('admin.layout')

@section('title', 'Car Categories')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Car Categories</h5>
                @if(Auth::user()->can('create_cars'))
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    Add New Category
                </button>
                @endif
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Number of Cars</th>
                                <th>Seats</th>
                                <th>Daily Rate</th>
                                <th>Picture</th>
                                <th>Status</th>
                                <th>Favorite</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description, 50) }}</td>
                                    <td>{{ $category->number_of_cars }}</td>
                                    <td>{{ $category->seats ?? '-' }}</td>
                                    <td>{{ $category->daily_rate ? number_format($category->daily_rate, 2) : '-' }}</td>
                                    <td>
                                        @if($category->picture)
                                            <img src="{{ asset($category->picture) }}" alt="Category Picture" width="50" height="40" style="object-fit:cover;">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $category->is_favorite ? 'bg-success' : 'bg-danger' }}">
                                            {{ $category->is_favorite ? 'Favorite' : 'Not Favorite' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(Auth::user()->can('edit_cars'))
                                        <button type="button" class="btn btn-sm btn-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editCategoryModal{{ $category->id }}">
                                            Edit
                                        </button>
                                        @endif
                                        @if(Auth::user()->can('edit_cars'))
                                        <form action="{{ route('admin.car-categories.toggle-favorite', $category) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $category->is_favorite ? 'btn-warning' : 'btn-success' }}" 
                                                    title="{{ $category->is_favorite ? 'Remove from favorites' : 'Add to favorites' }}">
                                                <i class="fa fa-heart"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @if(Auth::user()->can('delete_cars'))
                                        <form action="{{ route('admin.car-categories.destroy', $category) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.car-categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="number_of_cars" class="form-label">Number of Cars</label>
                        <input type="number" class="form-control" id="number_of_cars" name="number_of_cars" min="0" value="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="seats" class="form-label">Number of Seats (optional)</label>
                        <input type="number" class="form-control" id="seats" name="seats" min="1">
                    </div>
                    <div class="mb-3">
                        <label for="daily_rate" class="form-label">Daily Rate (TZS)</label>
                        <input type="number" step="0.01" class="form-control" id="daily_rate" name="daily_rate">
                    </div>
                    <div class="mb-3">
                        <label for="picture" class="form-label">Category Picture</label>
                        <input type="file" class="form-control" id="picture" name="picture" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_favorite" name="is_favorite" value="1">
                            <label class="form-check-label" for="is_favorite">Mark as Favorite (Show in carousel)</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modals -->
@foreach($categories as $category)
<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.car-categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name{{ $category->id }}" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name{{ $category->id }}" 
                               name="name" value="{{ $category->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="description{{ $category->id }}" class="form-label">Description</label>
                        <textarea class="form-control" id="description{{ $category->id }}" 
                                  name="description" rows="3">{{ $category->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="number_of_cars{{ $category->id }}" class="form-label">Number of Cars</label>
                        <input type="number" class="form-control" id="number_of_cars{{ $category->id }}" 
                               name="number_of_cars" min="0" value="{{ $category->number_of_cars }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="seats{{ $category->id }}" class="form-label">Number of Seats (optional)</label>
                        <input type="number" class="form-control" id="seats{{ $category->id }}" name="seats" min="1" value="{{ $category->seats }}">
                    </div>
                    <div class="mb-3">
                        <label for="daily_rate{{ $category->id }}" class="form-label">Daily Rate (TZS)</label>
                        <input type="number" step="0.01" class="form-control" id="daily_rate{{ $category->id }}" name="daily_rate" value="{{ $category->daily_rate }}">
                    </div>
                    <div class="mb-3">
                        <label for="picture{{ $category->id }}" class="form-label">Category Picture</label>
                        <input type="file" class="form-control" id="picture{{ $category->id }}" name="picture" accept="image/*">
                        @if($category->picture)
                            <div class="mt-2">
                                <img src="{{ asset($category->picture) }}" alt="Category Picture" width="50" height="40" style="object-fit:cover;">
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" 
                                   id="is_active{{ $category->id }}" 
                                   name="is_active" value="1" 
                                   {{ $category->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active{{ $category->id }}">Active</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" 
                                   id="is_favorite{{ $category->id }}" 
                                   name="is_favorite" value="1" 
                                   {{ $category->is_favorite ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_favorite{{ $category->id }}">Mark as Favorite (Show in carousel)</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection 