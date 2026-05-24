@extends('layouts.app')

@section('title', 'Shopping Cart - Sale ComputerShop')

@section('styles')
<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
    }
    
    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 0;
        width: 90%;
        max-width: 500px;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 16px 16px 0 0;
    }
    
    .modal-body {
        padding: 25px;
    }
    
    .modal-footer {
        padding: 15px 25px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    
    .close {
        color: white;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }
    
    .close:hover {
        color: #ddd;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    
    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    
    .form-group input:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
    }
    
    .required:after {
        content: " *";
        color: red;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: transform 0.2s;
    }
    
    .btn-primary:hover {
        transform: scale(1.02);
    }
    
    .btn-secondary {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
    }
    
    .cart-number-badge {
        background: #f0f0f0;
        padding: 8px 15px;
        border-radius: 20px;
        font-family: monospace;
        font-size: 14px;
        display: inline-block;
        margin-bottom: 15px;
    }
    
    .info-note {
        background: #e3f2fd;
        padding: 12px;
        border-radius: 8px;
        font-size: 13px;
        color: #1976d2;
        margin-top: 15px;
    }
</style>
@endsection

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">
        <i class="fas fa-shopping-cart text-blue-600"></i> Shopping Cart
    </h1>
    
    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart Items Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <form action="{{ route('cart.update') }}" method="POST" id="cartForm">
                        @csrf
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Product</th>
                                        <th class="px-4 py-3 text-center">Quantity</th>
                                        <th class="px-4 py-3 text-right">Price</th>
                                        <th class="px-4 py-3 text-right">Subtotal</th>
                                        <th class="px-4 py-3 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                @if($item['image'] ?? false)
                                                    <img src="{{ $item['image'] }}" class="w-12 h-12 object-cover rounded">
                                                @else
                                                    <i class="fas fa-desktop text-2xl text-gray-400"></i>
                                                @endif
                                                <div>
                                                    <p class="font-semibold">{{ $item['name'] }}</p>
                                                    <p class="text-xs text-gray-500">{{ $item['brand'] }}</p>
                                                    <p class="text-xs text-gray-400">{{ Str::limit($item['specs'] ?? 'No specs', 40) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" max="99" class="w-20 text-center border rounded-lg px-2 py-1">
                                        </td>
                                        <td class="px-4 py-3 text-right">${{ number_format($item['price'], 2) }}</td>
                                        <td class="px-4 py-3 text-right font-bold text-blue-600">
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <button type="button" onclick="openModal('{{ $id }}')" class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </button>
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-800 ml-2" onclick="return confirm('Remove this item?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="5" class="px-4 py-3 text-right">
                                            <button type="button" onclick="openUpdateCartModal()" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                                                <i class="fas fa-sync-alt"></i> Update Cart
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Cart Summary Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold mb-4 border-b pb-2">
                        <i class="fas fa-receipt"></i> Cart Summary
                    </h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Items:</span>
                            <span class="font-semibold">{{ count($cart) }} items</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="font-semibold">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping:</span>
                            <span class="font-semibold">{{ $total > 50 ? 'Free' : '$10.00' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax (10%):</span>
                            <span class="font-semibold">${{ number_format($total * 0.1, 2) }}</span>
                        </div>
                        <div class="border-t pt-3 mt-3">
                            <div class="flex justify-between text-xl font-bold">
                                <span>Total:</span>
                                <span class="text-blue-600">${{ number_format($total + ($total > 50 ? 0 : 10) + ($total * 0.1), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-2xl font-bold text-gray-600 mb-2">Your cart is empty!</h2>
            <p class="text-gray-500 mb-6">Looks like you haven't added any products to your cart yet.</p>
            <a href="{{ route('products.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                <i class="fas fa-shopping"></i> Continue Shopping
            </a>
        </div>
    @endif
</div>

<!-- Modal Popup for Update Cart with Customer Information -->
<div id="updateCartModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 style="margin: 0; font-size: 24px;">
                <i class="fas fa-edit"></i> Update Cart Information
            </h2>
            <p style="margin: 10px 0 0; opacity: 0.9;">Please provide your details to proceed</p>
        </div>
        
        <form action="{{ route('cart.update.with.info') }}" method="POST" id="updateCartWithInfoForm">
            @csrf
            <input type="hidden" name="cart_data" id="cartData">
            
            <div class="modal-body">
                <!-- Cart Number (Auto-generated) -->
                <div class="form-group">
                    <label class="required">🆔 Cart Number / Order Reference</label>
                    <div class="cart-number-badge">
                        <i class="fas fa-hashtag"></i> 
                        <span id="cartNumber">{{ 'CART-' . strtoupper(uniqid()) . '-' . date('Ymd') }}</span>
                    </div>
                    <input type="hidden" name="cart_number" id="cartNumberInput" value="{{ 'CART-' . strtoupper(uniqid()) . '-' . date('Ymd') }}">
                    <small class="text-gray-500">This is your unique cart reference number</small>
                </div>
                
                <!-- Full Name -->
                <div class="form-group">
                    <label class="required">👤 Full Name</label>
                    <input type="text" name="full_name" id="fullName" required 
                           placeholder="Enter your full name"
                           value="{{ old('full_name', Auth::user()->name ?? '') }}">
                </div>
                
                <!-- Email Address -->
                <div class="form-group">
                    <label class="required">📧 Email Address</label>
                    <input type="email" name="email" id="email" required 
                           placeholder="your@email.com"
                           value="{{ old('email', Auth::user()->email ?? '') }}">
                </div>
                
                <!-- Phone Number -->
                <div class="form-group">
                    <label class="required">📱 Phone Number</label>
                    <input type="tel" name="phone" id="phone" required 
                           placeholder="+1 234 567 8900"
                           value="{{ old('phone', '') }}">
                </div>
                
                <!-- Alternative Phone (Optional) -->
                <div class="form-group">
                    <label>📞 Alternative Phone (Optional)</label>
                    <input type="tel" name="alt_phone" id="altPhone" 
                           placeholder="Alternative contact number">
                </div>
                
                <!-- Delivery Address -->
                <div class="form-group">
                    <label class="required">📍 Delivery Address</label>
                    <textarea name="address" id="address" required rows="3" 
                              placeholder="Street Address, City, State, Zip Code, Country"></textarea>
                </div>
                
                <!-- Special Instructions -->
                <div class="form-group">
                    <label>📝 Special Instructions (Optional)</label>
                    <textarea name="instructions" id="instructions" rows="2" 
                              placeholder="Any special delivery instructions or notes"></textarea>
                </div>
                
                <div class="info-note">
                    <i class="fas fa-info-circle"></i> 
                    Your information will be saved and used for order processing. We'll contact you using these details.
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-check-circle"></i> Save & Update Cart
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal functions
    function openUpdateCartModal() {
        var modal = document.getElementById('updateCartModal');
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
        
        // Generate new cart number
        var timestamp = new Date().getTime();
        var cartNumber = 'CART-' + timestamp.toString().substring(5) + '-' + new Date().toISOString().slice(0,10).replace(/-/g, '');
        document.getElementById('cartNumber').innerText = cartNumber;
        document.getElementById('cartNumberInput').value = cartNumber;
        
        // Load saved data from localStorage if exists
        loadSavedCartData();
    }
    
    function closeModal() {
        var modal = document.getElementById('updateCartModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    function loadSavedCartData() {
        var savedData = localStorage.getItem('cartCustomerInfo');
        if (savedData) {
            var data = JSON.parse(savedData);
            if (data.full_name) document.getElementById('fullName').value = data.full_name;
            if (data.email) document.getElementById('email').value = data.email;
            if (data.phone) document.getElementById('phone').value = data.phone;
            if (data.alt_phone) document.getElementById('altPhone').value = data.alt_phone;
            if (data.address) document.getElementById('address').value = data.address;
            if (data.instructions) document.getElementById('instructions').value = data.instructions;
        }
    }
    
    // Save form data to localStorage
    document.getElementById('updateCartWithInfoForm').addEventListener('submit', function(e) {
        var formData = {
            full_name: document.getElementById('fullName').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            alt_phone: document.getElementById('altPhone').value,
            address: document.getElementById('address').value,
            instructions: document.getElementById('instructions').value,
            cart_number: document.getElementById('cartNumberInput').value,
            saved_at: new Date().toISOString()
        };
        
        localStorage.setItem('cartCustomerInfo', JSON.stringify(formData));
        
        // Show loading indicator
        var submitBtn = this.querySelector('button[type="submit"]');
        var originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        submitBtn.disabled = true;
        
        // Allow form to submit
        return true;
    });
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        var modal = document.getElementById('updateCartModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@endsection