<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|url|max:1000'
        ]);

        try {
            Product::create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'image' => $request->image
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error creating product: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|url|max:1000'
        ]);

        try {
            $product->update([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'image' => $request->image
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        try {
            // Hapus gambar
            if ($product->image) {
                Storage::delete('public/products/' . $product->image);
            }

            $product->delete();
            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }
} 