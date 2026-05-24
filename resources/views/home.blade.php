@extends('layouts.app')

@section('title', 'Sale ComputerShop - Best Computer Deals')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl p-12 text-center text-white mb-12">
    <h1 class="text-5xl font-bold mb-4 animate-pulse">Welcome to Sale ComputerShop</h1>
    <p class="text-xl mb-8">Your store of choice for all your computer needs.</p>
    <div class="flex gap-4 justify-center flex-wrap">
        <a href="/products" class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:shadow-lg transition transform hover:scale-105">
            <i class="fas fa-shopping-bag"></i> Shop Now
        </a>
        @guest
            <a href="/register" class="bg-orange-500 px-8 py-3 rounded-full font-semibold hover:bg-orange-600 transition">
                <i class="fas fa-user-plus"></i> Create Account
            </a>
            <a href="/login" class="bg-green-500 px-8 py-3 rounded-full font-semibold hover:bg-green-600 transition">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </a>
        @endguest
    </div>
</div>

<!-- Features Banner -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
    <div class="bg-white rounded-xl p-6 text-center shadow hover:shadow-lg transition">
        <i class="fas fa-truck-fast text-4xl text-blue-600 mb-3"></i>
        <h3 class="font-bold text-lg">Free Shipping</h3>
        <p class="text-gray-600 text-sm">Get free shipping on orders over $50.</p>
    </div>
    <div class="bg-white rounded-xl p-6 text-center shadow hover:shadow-lg transition">
        <i class="fas fa-tag text-4xl text-green-600 mb-3"></i>
        <h3 class="font-bold text-lg">Weekly Promotions</h3>
        <p class="text-gray-600 text-sm">Enjoy up to 20% off selected items every week.</p>
    </div>
    <div class="bg-white rounded-xl p-6 text-center shadow hover:shadow-lg transition">
        <i class="fas fa-headset text-4xl text-purple-600 mb-3"></i>
        <h3 class="font-bold text-lg">24/7 Support</h3>
        <p class="text-gray-600 text-sm">Need help? We're here for you.</p>
    </div>
</div>

<!-- Category Icons -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
    <a href="/products?category=laptops" class="bg-white p-6 rounded-xl text-center shadow hover:shadow-lg transition transform hover:scale-105 group">
        <i class="fas fa-laptop text-4xl text-blue-600 group-hover:scale-110 transition"></i>
        <p class="font-semibold mt-2">Laptops</p>
        <p class="text-xs text-gray-500">Gaming & Business</p>
    </a>
    <a href="/products?category=desktops" class="bg-white p-6 rounded-xl text-center shadow hover:shadow-lg transition transform hover:scale-105 group">
        <i class="fas fa-desktop text-4xl text-green-600 group-hover:scale-110 transition"></i>
        <p class="font-semibold mt-2">Desktops</p>
        <p class="text-xs text-gray-500">Powerful PCs</p>
    </a>
    <a href="/products?cpu_brand=Intel" class="bg-white p-6 rounded-xl text-center shadow hover:shadow-lg transition transform hover:scale-105 group">
        <i class="fab fa-intel text-4xl text-blue-600 group-hover:scale-110 transition"></i>
        <p class="font-semibold mt-2">Intel</p>
        <p class="text-xs text-gray-500">Core Processors</p>
    </a>
    <a href="/products?cpu_brand=AMD" class="bg-white p-6 rounded-xl text-center shadow hover:shadow-lg transition transform hover:scale-105 group">
        <i class="fas fa-microchip text-4xl text-red-600 group-hover:scale-110 transition"></i>
        <p class="font-semibold mt-2">AMD</p>
        <p class="text-xs text-gray-500">Ryzen Series</p>
    </a>
</div>

<!-- Featured Products -->
<div class="mb-12">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold"><i class="fas fa-star text-yellow-500"></i> Featured Products</h2>
        <a href="/products" class="text-blue-600 hover:underline">View All →</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($featuredProducts as $product)
        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" class="h-40 object-contain">
                @else
                    <i class="fas fa-desktop text-6xl text-gray-400"></i>
                @endif
            </div>
            <div class="p-4">
                <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                <p class="text-sm text-gray-600">{{ $product->brand }} {{ $product->model }}</p>
                <div class="text-sm mt-2">
                    @if($product->cpu_brand)<p><i class="fas fa-microchip"></i> {{ $product->cpu_brand }} {{ $product->cpu_speed }}GHz</p>@endif
                    @if($product->ram_size)<p><i class="fas fa-memory"></i> {{ $product->ram_size }} {{ $product->ram_type }}</p>@endif
                </div>
                <div class="mt-3 flex justify-between items-center">
                    <span class="text-2xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                    @if($product->stock > 0)
                        <form action="/cart/add/{{ $product->id }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm">
                                <i class="fas fa-cart-plus"></i> Add
                            </button>
                        </form>
                    @endif
                </div>
                <a href="/product/{{ $product->id }}" class="block mt-3 text-center text-blue-600 hover:underline text-sm">View Details →</a>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Recent Orders -->
<div>
    <h2 class="text-2xl font-bold mb-4"><i class="fas fa-receipt"></i> Recent Orders</h2>
    @if($recentOrders->count() > 0)
        <div class="bg-white rounded-xl overflow-hidden shadow">
            <table class="min-w-full">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Order #</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-center">Items</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono text-sm">{{ $order->order_number }}</td>
                        <td class="px-4 py-3">{{ $order->customer_name }}</td>
                        <td class="px-4 py-3 text-center">{{ $order->items->sum('quantity') }} items</td>
                        <td class="px-4 py-3 text-right font-bold">${{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $order->status_badge }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No orders yet.</p>
    @endif
</div>
@endsection