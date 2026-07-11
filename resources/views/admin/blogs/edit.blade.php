@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold" style="font-weight: 700;">Edit Blog Post</h1>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="content-card">
            <div class="card-header-custom">
                <h5>Update Blog Post: {{ $blog->title }}</h5>
            </div>
            <div class="card-body-custom">
                <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Left Column: Title, Slug, Details -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label font-weight-bold">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $blog->title) }}" placeholder="Enter blog title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label font-weight-bold">Slug (Editable)</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $blog->slug) }}" placeholder="blog-slug" required>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="details" class="form-label font-weight-bold">Details</label>
                                <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="10">{{ old('details', $blog->details) }}</textarea>
                                @error('details')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column: Category, Status, Image -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category_id" class="form-label font-weight-bold">Category</label>
                                <select class="form-select form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label font-weight-bold">Status</label>
                                <select class="form-select form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="Active" {{ old('status', $blog->status) === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status', $blog->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label font-weight-bold">Featured Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept=".jpeg,.jpg,.png,.webp">
                                <div class="form-text">Leave blank to keep existing image. Supported: JPG, JPEG, PNG, WebP (Max 2MB).</div>
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                
                                <div class="mt-3">
                                    <label class="d-block form-label font-weight-bold">Image Preview</label>
                                    <div class="image-preview-container" id="image-preview-wrapper">
                                        <img id="image-preview" src="{{ asset($blog->image) }}" alt="Featured Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary" style="border-radius: 10px; padding: 12px 20px;">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="padding: 12px 20px;">Update Blog Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- CKEditor 5 Build Classic -->
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#details'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
        })
        .catch(error => {
            console.error(error);
        });

    // Image preview handler
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            const previewImg = document.getElementById('image-preview');
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
