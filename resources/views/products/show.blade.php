@extends('layouts.app')

@section('title', $product->name . ' - Sale ComputerShop')

@section('content')
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="grid md:grid-cols-2 gap-8 p-6">
        <!-- Product Image -->
        <div class="bg-gray-100 rounded-xl flex items-center justify-center p-8 min-h-[300px]">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" class="max-h-80 object-contain">
            @else
                <i class="fas fa-desktop text-8xl text-gray-400"></i>
            @endif
        </div>
        
        <!-- Product Info -->
        <div>
            <div class="flex items-center gap-2 mb-2 flex-wrap">
                @if($product->featured)
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full"><i class="fas fa-star"></i> Featured</span>
                @endif
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $product->category->name ?? 'Product' }}</span>
                <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full"><i class="fas fa-box"></i> Stock: {{ $product->stock }} units</span>
            </div>
            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $product->brand }} {{ $product->model }}</p>
            
            <!-- Key Specs -->
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <h3 class="font-bold mb-3"><i class="fas fa-list-ul"></i> Key Specifications</h3>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    @if($product->cpu_brand)
                        <div><strong>CPU:</strong> {{ $product->cpu_brand }} {{ $product->cpu_model }} ({{ $product->cpu_speed }} GHz, {{ $product->cpu_cores }} Cores)</div>
                    @endif
                    @if($product->ram_size)
                        <div><strong>RAM:</strong> {{ $product->ram_size }} {{ $product->ram_type }}</div>
                    @endif
                    @if($product->gpu_model)
                        <div><strong>GPU:</strong> {{ $product->gpu_model }}</div>
                    @endif
                    @if($product->storage)
                        <div><strong>Storage:</strong> {{ $product->storage }} {{ $product->storage_type }}</div>
                    @endif
                    @if($product->monitor_size)
                        <div><strong>Monitor:</strong> {{ $product->monitor_size }} {{ $product->monitor_resolution }} @if($product->monitor_refresh_rate)({{ $product->monitor_refresh_rate }}Hz)@endif</div>
                    @endif
                </div>
            </div>
            
            <!-- Product Details -->
            @if($product->details)
            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                <h3 class="font-bold mb-2"><i class="fas fa-info-circle"></i> Product Details</h3>
                <div class="text-sm whitespace-pre-line">{{ $product->details }}</div>
            </div>
            @endif
            
            <!-- Technical Specs -->
            @if($product->specifications)
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <h3 class="font-bold mb-2"><i class="fas fa-microchip"></i> Technical Specifications</h3>
                <div class="text-sm whitespace-pre-line">{{ $product->specifications }}</div>
            </div>
            @endif
            
            <!-- Price & Actions -->
            <div class="mb-4">
                <span class="text-3xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                @if($product->stock > 0)
                    <span class="ml-3 text-green-600"><i class="fas fa-check-circle"></i> In Stock</span>
                @else
                    <span class="ml-3 text-red-600"><i class="fas fa-times-circle"></i> Out of Stock</span>
                @endif
            </div>
            
            @if($product->stock > 0)
                <form action="/cart/add/{{ $product->id }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-cart-plus"></i> Add to Cart
                    </button>
                    <a href="/checkout" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition ml-3">
                        <i class="fas fa-bolt"></i> Buy Now
                    </a>
                </form>
            @endif
        </div>
    </div>
</div>

<!-- Related Products -->
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<div class="mt-12">
    <h2 class="text-2xl font-bold mb-6">Related Products</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($relatedProducts as $related)
        <div class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition">
            <div class="h-36 bg-gray-100 flex items-center justify-center">
                @if($related->image_url)
                    <img src="{{ $related->image_url }}" class="h-28 object-contain">
                @else
                    <i class="fas fa-desktop text-4xl text-gray-400"></i>
                @endif
            </div>
            <div class="p-3">
                <h3 class="font-bold text-sm">{{ $related->name }}</h3>
                <p class="text-xs text-gray-500">{{ $related->brand }}</p>
                <div class="mt-2 flex justify-between items-center">
                    <span class="font-bold text-blue-600">${{ number_format($related->price, 2) }}</span>
                    <form action="/cart/add/{{ $related->id }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded-lg text-xs">Add</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection