<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalSliders = Slider::count();
        $totalUsers = User::count();
        
        $latestProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();
            
        $latestUsers = User::latest()
            ->take(5)
            ->get();
            
        $activeSliders = Slider::latest()
            ->take(3)
            ->get();
            
        $categories = Category::withCount('products')
            ->get();
        
        return view('admin.dashboard', compact(
            'totalCategories',
            'totalProducts',
            'totalSliders',
            'totalUsers',
            'latestProducts',
            'latestUsers',
            'activeSliders',
            'categories'
        ));
    }
} 