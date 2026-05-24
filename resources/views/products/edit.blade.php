@extends('layouts.app')

@section('title', 'Edit Product - Admin')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h1 class="text-3xl font-bold mb-6"><i class="fas fa-edit"></i> Edit Product</h1>
        <form action="/admin/products/{{ $product->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div><label class="font-semibold">Name</label><input type="text" name="name" value="{{ $product->name }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">Category</label><select name="category_id" class="w-full border rounded px-3 py-2">@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach</select></div>
                <div><label class="font-semibold">Brand</label><input type="text" name="brand" value="{{ $product->brand }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">Model</label><input type="text" name="model" value="{{ $product->model }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">CPU Brand</label><input type="text" name="cpu_brand" value="{{ $product->cpu_brand }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">CPU Speed</label><input type="number" name="cpu_speed" step="0.1" value="{{ $product->cpu_speed }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">RAM Size</label><input type="text" name="ram_size" value="{{ $product->ram_size }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">RAM Type</label><input type="text" name="ram_type" value="{{ $product->ram_type }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">GPU Model</label><input type="text" name="gpu_model" value="{{ $product->gpu_model }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">Price</label><input type="number" name="price" step="0.01" value="{{ $product->price }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">Stock</label><input type="number" name="stock" value="{{ $product->stock }}" class="w-full border rounded px-3 py-2"></div>
                <div><label class="font-semibold">Image URL</label><input type="url" name="image_url" value="{{ $product->image_url }}" class="w-full border rounded px-3 py-2"></div>
                <div class="col-span-2"><textarea name="details" rows="4" class="w-full border rounded px-3 py-2" placeholder="Details">{{ $product->details }}</textarea></div>
                <div class="col-span-2"><textarea name="specifications" rows="4" class="w-full border rounded px-3 py-2" placeholder="Specifications">{{ $product->specifications }}</textarea></div>
            </div>
            <div class="flex justify-between mt-6"><a href="/products" class="px-6 py-2 border rounded">Cancel</a><button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">Update</button></div>
        </form>
    </div>
</div>
@endsection