@extends('layouts.app')

@section('title', 'All Products - Sale ComputerShop')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">All Products</h1>
    @auth
        @if(Auth::user()->isAdmin())
            <a href="/admin/products/create" class="bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Add New Computer
            </a>
        @endif
    @endauth
</div>

<div class="flex flex-col lg:flex-row gap-6">
    <!-- Filters Sidebar -->
    <div class="lg:w-1/4">
        <div class="bg-white rounded-xl p-5 shadow sticky top-24">
            <h3 class="font-bold text-lg mb-4"><i class="fas fa-sliders-h"></i> Filters</h3>
            <form method="GET" action="/products" id="filter-form">
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Category</label>
                    <select name="category" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">CPU Brand</label>
                    <select name="cpu_brand" class="w-full border rounded-lg px-3 py-2" onchange="this.form.submit()">
                        <option value="all">All Brands</option>
                        <option value="Intel" {{ request('cpu_brand') == 'Intel' ? 'selected' : '' }}>Intel Core</option>
                        <option value="AMD" {{ request('cpu_brand') == 'AMD' ? 'selected' : '' }}>AMD Ryzen</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Sort By</label>
                    <select name="sort" class="w-full border rounded-lg px-3 py-2" onchange="this.form.submit()">
                        <option value="">Newest First</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Search</label>
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="w-full border rounded-lg px-3 py-2">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    <a href="/products" class="flex-1 bg-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm text-center hover:bg-gray-400 transition">
                        <i class="fas fa-undo"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Products Grid -->
    <div class="lg:w-3/4">
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" class="h-40 object-contain">
                        @else
                            <i class="fas fa-desktop text-6xl text-gray-400"></i>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $product->brand }} {{ $product->model }}</p>
                            </div>
                            @if($product->featured)
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full"><i class="fas fa-star"></i></span>
                            @endif
                        </div>
                        <div class="text-sm mt-2 space-y-1">
                            @if($product->cpu_brand)<p><i class="fas fa-microchip text-blue-500"></i> {{ $product->cpu_brand }} {{ $product->cpu_speed }}GHz</p>@endif
                            @if($product->ram_size)<p><i class="fas fa-memory text-green-500"></i> {{ $product->ram_size }} {{ $product->ram_type }}</p>@endif
                            @if($product->gpu_model)<p><i class="fas fa-tv text-purple-500"></i> {{ $product->gpu_model }}</p>@endif
                        </div>
                        <div class="mt-3 flex justify-between items-center">
                            <div>
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</span>
                                @if($product->isLowStock())
                                    <p class="text-xs text-orange-600"><i class="fas fa-exclamation-triangle"></i> Only {{ $product->stock }} left</p>
                                @elseif($product->stock > 0)
                                    <p class="text-xs text-green-600"><i class="fas fa-check"></i> In Stock</p>
                                @else
                                    <p class="text-xs text-red-600">Out of Stock</p>
                                @endif
                            </div>
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
                        
                        @auth
                            @if(Auth::user()->isAdmin())
                                <div class="mt-3 flex gap-2 border-t pt-3">
                                    <a href="/admin/products/{{ $product->id }}/edit" class="flex-1 text-center bg-yellow-500 text-white px-2 py-1 rounded text-sm hover:bg-yellow-600 transition">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="/admin/products/{{ $product->id }}" method="POST" class="flex-1" onsubmit="return confirm('Delete {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600 transition">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-600 mb-2">No products found</h2>
                <p class="text-gray-500 mb-6">Try adjusting your search or filter criteria.</p>
                <a href="/products" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-undo"></i> Clear all filters
                </a>
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="/admin/products/create" class="inline-block ml-3 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>
@endsection