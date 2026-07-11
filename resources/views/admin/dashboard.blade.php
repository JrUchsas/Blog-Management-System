@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold" style="font-weight: 700;">Dashboard</h1>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <!-- Total Categories Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-details">
                <h3>{{ $totalCategories }}</h3>
                <span>Total Categories</span>
            </div>
            <div class="stat-icon icon-blue">
                <i class="bi bi-tags"></i>
            </div>
        </div>
    </div>

    <!-- Total Blog Posts Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-details">
                <h3>{{ $totalBlogs }}</h3>
                <span>Total Blog Posts</span>
            </div>
            <div class="stat-icon icon-green">
                <i class="bi bi-file-earmark-post"></i>
            </div>
        </div>
    </div>

    <!-- Total Users Card -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card">
            <div class="stat-details">
                <h3>{{ $totalUsers }}</h3>
                <span>Total Registered Users</span>
            </div>
            <div class="stat-icon icon-purple">
                <i class="bi bi-people"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Latest Blog Posts -->
    <div class="col-xl-7 col-lg-6">
        <div class="content-card">
            <div class="card-header-custom">
                <h5>Latest Blog Posts</h5>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 8px;">View All</a>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestBlogs as $blog)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ Str::limit($blog->title, 35) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary" style="border-radius: 6px;">{{ $blog->category->name }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ $blog->status === 'Active' ? 'badge-active' : 'badge-inactive' }}">
                                            {{ $blog->status }}
                                        </span>
                                    </td>
                                    <td class="text-muted">{{ $blog->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No blog posts found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Registered Users -->
    <div class="col-xl-5 col-lg-6">
        <div class="content-card">
            <div class="card-header-custom">
                <h5>Latest Registered Users</h5>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestUsers as $user)
                                <tr>
                                    <td class="fw-bold">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
