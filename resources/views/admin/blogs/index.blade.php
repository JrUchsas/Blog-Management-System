@extends('layouts.admin')

@section('title', 'Blog List')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold" style="font-weight: 700;">Blog Posts</h1>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Blog Post
    </a>
</div>

<div class="content-card">
    <div class="card-header-custom">
        <h5>Blog List</h5>
        
        <!-- Search Bar -->
        <form action="{{ route('admin.blogs.index') }}" method="GET" class="d-flex" style="max-width: 300px; width: 100%;">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search blogs..." value="{{ $search }}" style="border-radius: 8px 0 0 8px;">
                <button class="btn btn-outline-secondary" type="submit" style="border-radius: 0 8px 8px 0;">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            @if($search)
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-link text-muted ms-2 p-0 align-self-center"><i class="bi bi-x-circle-fill fs-5"></i></a>
            @endif
        </form>
    </div>
    
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th style="width: 100px;">Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th class="text-end" style="width: 250px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                        <tr>
                            <td>{{ $blog->id }}</td>
                            <td>
                                @if($blog->image)
                                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="rounded shadow-sm" style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td class="fw-bold">{{ Str::limit($blog->title, 40) }}</td>
                            <td>
                                <span class="badge bg-secondary" style="border-radius: 6px;">{{ $blog->category->name }}</span>
                            </td>
                            <td>
                                <span class="{{ $blog->status === 'Active' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $blog->status }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $blog->created_at->format('M d, Y') }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-sm btn-outline-info" style="border-radius: 8px;">
                                        <i class="bi bi-eye-fill"></i> View
                                    </a>
                                    <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 8px;">
                                            <i class="bi bi-trash-fill"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No blogs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-end mt-4">
    {{ $blogs->links('pagination::bootstrap-5') }}
</div>
@endsection
