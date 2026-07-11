@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold" style="font-weight: 700;">Edit Category</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="content-card">
            <div class="card-header-custom">
                <h5>Update Category: {{ $category->name }}</h5>
            </div>
            <div class="card-body-custom">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label font-weight-bold">Category Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="Enter category name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label font-weight-bold">Status</label>
                        <select class="form-select form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Active" {{ old('status', $category->status) === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $category->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary" style="border-radius: 10px; padding: 12px 20px;">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="padding: 12px 20px;">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
