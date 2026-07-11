<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs (with search and pagination).
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $blogs = Blog::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('details', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'LIKE', '%' . $search . '%');
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.blogs.index', compact('blogs', 'search'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        // Get only active categories for selection
        $categories = BlogCategory::where('status', 'Active')->orderBy('name')->get();
        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'details' => 'required|string',
            'category_id' => 'required|exists:blog_categories,id',
            'status' => 'required|in:Active,Inactive',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048', // max 2MB
        ]);

        // Process image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/blog');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $image->move($destinationPath, $imageName);
            $imagePath = 'uploads/blog/' . $imageName;
        }

        Blog::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->slug), // Ensure slug is formatted correctly
            'details' => $request->details,
            'image' => $imagePath ?? '',
            'status' => $request->status,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified blog details.
     */
    public function show(Blog $blog)
    {
        $blog->load('category');
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('status', 'Active')->orderBy('name')->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'details' => 'required|string',
            'category_id' => 'required|exists:blog_categories,id',
            'status' => 'required|in:Active,Inactive',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048', // max 2MB
        ]);

        $imagePath = $blog->image;

        // Process new image upload if exists
        if ($request->hasFile('image')) {
            // Delete old image file
            if (File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/blog');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $image->move($destinationPath, $imageName);
            $imagePath = 'uploads/blog/' . $imageName;
        }

        $blog->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->slug),
            'details' => $request->details,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog)
    {
        // Delete image file from filesystem
        if (File::exists(public_path($blog->image))) {
            File::delete(public_path($blog->image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully!');
    }
}
