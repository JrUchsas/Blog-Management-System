<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function index()
    {
        $totalCategories = BlogCategory::count();
        $totalBlogs = Blog::count();
        $totalUsers = User::count();

        // Get latest 5 blog posts with their categories
        $latestBlogs = Blog::with('category')
            ->latest()
            ->take(5)
            ->get();

        // Get latest 5 registered users
        $latestUsers = User::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalBlogs',
            'totalUsers',
            'latestBlogs',
            'latestUsers'
        ));
    }
}
