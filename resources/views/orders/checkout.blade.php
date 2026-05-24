@extends('layouts.app')

@section('title', 'Checkout - Sale ComputerShop')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6"><i class="fas fa-credit-card text-green-600"></i> Checkout</h1>
    
    <div class="grid md:grid-cols-3 gap-8">
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                @foreach($cart as $item)
                <div class="flex justify-between border-b py-3">
                    <div>
                        <p class="font-semibold">{{ $item['name'] }}</p>
                        <p class="text-sm text-gray-500">Quantity: {{ $item['quantity'] }}</p>
                    </div>
                    <p class="font-bold">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                </div>
                @endforeach
                
                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between"><span>Subtotal:</span><span>${{ number_format($subtotal, 2) }}</span></div>
                    <div class="flex justify-between mt-2"><span>Shipping:</span><span>{{ $shipping > 0 ? '$'.number_format($shipping,2) : 'Free' }}</span></div>
                    <div class="flex justify-between mt-2"><span>Tax (10%):</span><span>${{ number_format($tax, 2) }}</span></div>
                    <div class="flex justify-between mt-3 pt-3 border-t text-xl font-bold">
                        <span>Total:</span>
                        <span class="text-blue-600">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Confirm Information</h2>
                <form action="/order/place" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="customer_name" value="{{ $customerInfo['name'] ?? Auth::user()->name ?? '' }}" 
                               placeholder="Full Name" required class="w-full border rounded-lg px-3 py-2 bg-gray-50" readonly>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="customer_email" value="{{ $customerInfo['email'] ?? Auth::user()->email ?? '' }}" 
                               placeholder="Email" required class="w-full border rounded-lg px-3 py-2 bg-gray-50" readonly>
                    </div>
                    <div class="mb-3">
                        <input type="tel" name="customer_phone" value="{{ $customerInfo['phone'] ?? '' }}" 
                               placeholder="Phone" required class="w-full border rounded-lg px-3 py-2 bg-gray-50" readonly>
                    </div>
                    <div class="mb-3">
                        <textarea name="shipping_address" placeholder="Shipping Address" required rows="3" 
                                  class="w-full border rounded-lg px-3 py-2 bg-gray-50" readonly>{{ $customerInfo['address'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <select name="payment_method" required class="w-full border rounded-lg px-3 py-2">
                            <option value="cash_on_delivery">Cash on Delivery</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="credit_card">Credit/Debit Card</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <textarea name="notes" rows="2" placeholder="Additional notes (optional)" 
                                  class="w-full border rounded-lg px-3 py-2">{{ $customerInfo['notes'] ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700">
                        <i class="fas fa-check-circle"></i> Confirm Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection