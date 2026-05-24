<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('featured', true)->latest()->limit(8)->get();
        $latestProducts = Product::latest()->limit(8)->get();
        $categories = Category::all();
        $recentOrders = Order::with('items')->latest()->limit(5)->get();
        
        return view('home', compact('featuredProducts', 'latestProducts', 'categories', 'recentOrders'));
    }
}