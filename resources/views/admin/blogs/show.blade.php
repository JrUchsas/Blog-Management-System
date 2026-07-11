@extends('layouts.admin')

@section('title', 'Blog Details')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold" style="font-weight: 700;">Blog Details</h1>
    <div>
        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil-fill me-1"></i> Edit Post
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="content-card">
            <!-- Header section -->
            <div class="card-header-custom flex-column align-items-start gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-secondary" style="border-radius: 6px; padding: 6px 12px; font-size: 0.85rem;">
                        {{ $blog->category->name }}
                    </span>
                    <span class="{{ $blog->status === 'Active' ? 'badge-active' : 'badge-inactive' }}" style="font-size: 0.85rem;">
                        {{ $blog->status }}
                    </span>
                </div>
                <h2 class="mt-2 text-dark font-weight-bold" style="font-weight: 700; line-height: 1.3;">{{ $blog->title }}</h2>
                <div class="text-muted" style="font-size: 0.9rem;">
                    <i class="bi bi-calendar-event me-1"></i> Published on: <strong>{{ $blog->created_at->format('M d, Y') }}</strong>
                    <span class="mx-2">|</span>
                    <i class="bi bi-link-45deg me-1"></i> Slug: <code>{{ $blog->slug }}</code>
                </div>
            </div>

            <!-- Image section -->
            @if($blog->image)
                <div class="text-center bg-light border-bottom overflow-hidden d-flex justify-content-center align-items-center" style="max-height: 450px;">
                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="img-fluid w-100" style="object-fit: cover; max-height: 450px;">
                </div>
            @endif

            <!-- Body details section -->
            <div class="card-body-custom" style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main);">
                <div class="rich-text-content">
                    {!! $blog->details !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .rich-text-content p {
        margin-bottom: 1.5rem;
    }
    .rich-text-content ul, .rich-text-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
    .rich-text-content blockquote {
        border-left: 4px solid var(--primary-color);
        padding-left: 1.5rem;
        font-style: italic;
        color: var(--text-muted);
        margin: 1.5rem 0;
    }
</style>
@endsection
