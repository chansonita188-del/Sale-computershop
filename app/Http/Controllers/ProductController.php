<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->filled('category') && $request->category != 'all') {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('model', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('cpu_brand') && $request->cpu_brand != 'all') {
            $query->where('cpu_brand', $request->cpu_brand);
        }
        
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        if ($request->filled('sort')) {
            switch($request->sort) {
                case 'price_asc': $query->orderBy('price', 'asc'); break;
                case 'price_desc': $query->orderBy('price', 'desc'); break;
                case 'name_asc': $query->orderBy('name', 'asc'); break;
                default: $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $products = $query->paginate(12);
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }
    
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }
    
    public function create()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only Admin can add products.');
        }
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only Admin can add products.');
        }
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string',
            'model' => 'required|string',
            'product_type' => 'nullable|string',
            'cpu_brand' => 'nullable|string',
            'cpu_model' => 'nullable|string',
            'cpu_speed' => 'nullable|numeric',
            'cpu_cores' => 'nullable|integer',
            'gpu_brand' => 'nullable|string',
            'gpu_model' => 'nullable|string',
            'ram_size' => 'nullable|string',
            'ram_type' => 'nullable|string',
            'storage' => 'nullable|string',
            'storage_type' => 'nullable|string',
            'monitor_size' => 'nullable|string',
            'monitor_resolution' => 'nullable|string',
            'monitor_refresh_rate' => 'nullable|string',
            'details' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'featured' => 'nullable|boolean',
        ]);
        
        $validated['featured'] = $request->has('featured');
        Product::create($validated);
        
        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }
    
    public function edit(Product $product)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only Admin can edit products.');
        }
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }
    
    public function update(Request $request, Product $product)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only Admin can edit products.');
        }
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string',
            'model' => 'required|string',
            'product_type' => 'nullable|string',
            'cpu_brand' => 'nullable|string',
            'cpu_model' => 'nullable|string',
            'cpu_speed' => 'nullable|numeric',
            'cpu_cores' => 'nullable|integer',
            'gpu_brand' => 'nullable|string',
            'gpu_model' => 'nullable|string',
            'ram_size' => 'nullable|string',
            'ram_type' => 'nullable|string',
            'storage' => 'nullable|string',
            'storage_type' => 'nullable|string',
            'monitor_size' => 'nullable|string',
            'monitor_resolution' => 'nullable|string',
            'monitor_refresh_rate' => 'nullable|string',
            'details' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'featured' => 'nullable|boolean',
        ]);
        
        $validated['featured'] = $request->has('featured');
        $product->update($validated);
        
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }
    
    public function destroy(Product $product)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only Admin can delete products.');
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted!');
    }
}