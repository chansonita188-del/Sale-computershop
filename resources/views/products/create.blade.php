@extends('layouts.app')

@section('title', 'Add New Computer - Sale ComputerShop')

@section('styles')
<style>
    .form-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #e2e8f0;
    }
    .form-section-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #1e40af;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #3b82f6;
        display: inline-block;
    }
    .required:after {
        content: " *";
        color: red;
    }
</style>
@endsection

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">
                <i class="fas fa-plus-circle"></i> Add New Computer / Gaming Desktop
            </h1>
            <p class="text-green-100 text-sm mt-1">Fill in the details to add a new computer product to Sale ComputerShop</p>
        </div>
        
        <form action="/admin/products" method="POST" class="p-6">
            @csrf
            
            <!-- Basic Information -->
            <div class="form-section">
                <h2 class="form-section-title"><i class="fas fa-info-circle"></i> Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 required">Product Name</label>
                        <input type="text" name="name" required placeholder="e.g., Gaming Desktop Xtreme 9000" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 required">Category</label>
                        <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 required">Brand</label>
                        <input type="text" name="brand" required placeholder="e.g., ASUS, MSI, Dell, Custom" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 required">Model</label>
                        <input type="text" name="model" required placeholder="e.g., ROG Strix G15" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Product Type</label>
                        <select name="product_type" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                            <option value="computer">Computer / Desktop</option>
                            <option value="gaming_desktop">Gaming Desktop</option>
                            <option value="workstation">Workstation</option>
                            <option value="all_in_one">All-in-One</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Image URL</label>
                        <input type="url" name="image_url" placeholder="https://example.com/image.jpg" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                    </div>
                </div>
            </div>
            
            <!-- Processor / CPU -->
            <div class="form-section">
                <h2 class="form-section-title"><i class="fas fa-microchip"></i> Processor (CPU)</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">CPU Brand</label>
                        <select name="cpu_brand" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                            <option value="">Select</option>
                            <option value="Intel">Intel Core</option>
                            <option value="AMD">AMD Ryzen</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">CPU Model</label>
                        <input type="text" name="cpu_model" placeholder="e.g., i9-13900K" class="w-full border rounded-lg px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">CPU Speed (GHz)</label>
                        <input type="number" name="cpu_speed" step="0.1" placeholder="5.0" class="w-full border rounded-lg px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">CPU Cores</label>
                        <input type="number" name="cpu_cores" placeholder="8, 16, 24" class="w-full border rounded-lg px-4 py-2.5">
                    </div>
                </div>
            </div>
            
            <!-- Graphics Card -->
            <div class="form-section">
                <h2 class="form-section-title"><i class="fas fa-tv"></i> Graphics Card (GPU)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">GPU Brand</label>
                        <select name="gpu_brand" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                            <option value="">Select</option>
                            <option value="NVIDIA">NVIDIA GeForce</option>
                            <option value="AMD">AMD Radeon</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">GPU Model</label>
                        <input type="text" name="gpu_model" placeholder="e.g., RTX 4090" class="w-full border rounded-lg px-4 py-2.5">
                    </div>
                </div>
            </div>
            
            <!-- Memory & Storage -->
            <div class="form-section">
                <h2 class="form-section-title"><i class="fas fa-memory"></i> Memory & Storage</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">RAM Size</label>
                        <select name="ram_size" class="w-full border rounded-lg px-4 py-2.5">
                            <option value="">Select</option>
                            <option value="8GB">8GB</option>
                            <option value="16GB">16GB</option>
                            <option value="32GB">32GB</option>
                            <option value="64GB">64GB</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">RAM Type</label>
                        <select name="ram_type" class="w-full border rounded-lg px-4 py-2.5">
                            <option value="">Select</option>
                            <option value="DDR4">DDR4</option>
                            <option value="DDR5">DDR5</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Storage Size</label>
                        <select name="storage" class="w-full border rounded-lg px-4 py-2.5">
                            <option value="">Select</option>
                            <option value="256GB">256GB</option>
                            <option value="512GB">512GB</option>
                            <option value="1TB">1TB</option>
                            <option value="2TB">2TB</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Storage Type</label>
                        <select name="storage_type" class="w-full border rounded-lg px-4 py-2.5">
                            <option value="">Select</option>
                            <option value="SSD">SSD</option>
                            <option value="NVMe">NVMe SSD</option>
                            <option value="HDD">HDD</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Monitor Section -->
            <div class="form-section">
                <h2 class="form-section-title"><i class="fas fa-desktop"></i> Monitor / Display (Optional)</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Monitor Size</label>
                        <select name="monitor_size" class="w-full border rounded-lg px-4 py-2.5">
                            <option value="">No Monitor</option>
                            <option value="24\"">24-inch</option>
                            <option value="27\"">27-inch</option>
                            <option value="32\"">32-inch</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Resolution</label>
                        <select name="monitor_resolution" class="w-full border rounded-lg px-4 py-2.5">
                            <option value="">Select</option>
                            <option value="1920x1080">Full HD (1920x1080)</option>
                            <option value="2560x1440">QHD (2560x1440)</option>
                            <option value="3840x2160">4K UHD (3840x2160)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Refresh Rate</label>
                        <select name="monitor_refresh_rate" class="w-full border rounded-lg px-4 py-2.5">
                            <option value="">Select</option>
                            <option value="60">60Hz</option>
                            <option value="144">144Hz</option>
                            <option value="165">165Hz</option>
                            <option value="240">240Hz</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Detailed Description -->
            <div class="form-section">
                <h2 class="form-section-title"><i class="fas fa-align-left"></i> Detailed Description</h2>
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Details / Features</label>
                    <textarea name="details" rows="5" 
                              placeholder="Enter detailed product description here...
Example:
- High-performance gaming desktop with RGB lighting
- Liquid cooling system
- Includes keyboard and mouse
- 3-year warranty"
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Technical Specifications</label>
                    <textarea name="specifications" rows="4" 
                              placeholder="Motherboard, Power Supply, Cooling, etc."
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>
            </div>
            
            <!-- Pricing & Inventory -->
            <div class="form-section">
                <h2 class="form-section-title"><i class="fas fa-dollar-sign"></i> Pricing & Inventory</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 required">Price ($)</label>
                        <input type="number" name="price" step="0.01" required placeholder="1999.99" class="w-full border rounded-lg px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 required">Stock Quantity</label>
                        <input type="number" name="stock" required placeholder="10" class="w-full border rounded-lg px-4 py-2.5">
                    </div>
                    <div class="flex items-center pt-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="featured" value="1" class="w-4 h-4 text-green-600">
                            <span class="text-sm font-semibold text-gray-700">
                                <i class="fas fa-star text-yellow-500"></i> Feature on Homepage
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="flex justify-end gap-4 mt-6 pt-4 border-t">
                <a href="/products" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">
                    <i class="fas fa-save"></i> Add Computer Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection