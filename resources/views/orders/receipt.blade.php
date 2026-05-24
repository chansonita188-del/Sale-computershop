@extends('layouts.app')

@section('title', 'Order Receipt - Sale ComputerShop')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-8 text-center">
            <i class="fas fa-check-circle text-6xl mb-4"></i>
            <h1 class="text-3xl font-bold mb-2">Order Confirmed!</h1>
            <p class="text-lg">Thank you for shopping at Sale ComputerShop</p>
        </div>
        <div class="p-8">
            <div class="grid md:grid-cols-3 gap-6 pb-8 border-b"><div><p class="text-gray-500 text-sm">Order Number</p><p class="font-mono font-bold">{{ $order->order_number }}</p></div><div><p class="text-gray-500 text-sm">Order Date</p><p>{{ $order->created_at->format('F d, Y h:i A') }}</p></div><div><p class="text-gray-500 text-sm">Status</p><span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">{{ ucfirst($order->status) }}</span></div></div>
            <div class="grid md:grid-cols-2 gap-8 py-8 border-b"><div><h3 class="font-bold mb-3"><i class="fas fa-user"></i> Customer Information</h3><p><strong>Name:</strong> {{ $order->customer_name }}</p><p><strong>Email:</strong> {{ $order->customer_email }}</p><p><strong>Phone:</strong> {{ $order->customer_phone }}</p></div><div><h3 class="font-bold mb-3"><i class="fas fa-map-marker-alt"></i> Shipping Address</h3><p>{{ $order->shipping_address }}</p></div></div>
            <h3 class="font-bold mb-4 mt-8"><i class="fas fa-box"></i> Order Items</h3>
            <div class="overflow-x-auto"><table class="min-w-full border"><thead class="bg-gray-100"><tr><th class="px-4 py-3 text-left">Product</th><th class="px-4 py-3 text-center">Qty</th><th class="px-4 py-3 text-right">Price</th><th class="px-4 py-3 text-right">Subtotal</th></tr></thead><tbody>@foreach($order->items as $item)<tr class="border-t"><td class="px-4 py-3">{{ $item->product_name }}</td><td class="px-4 py-3 text-center">{{ $item->quantity }}</td><td class="px-4 py-3 text-right">${{ number_format($item->unit_price, 2) }}</td><td class="px-4 py-3 text-right">${{ number_format($item->subtotal, 2) }}</td></tr>@endforeach</tbody><tfoot><tr class="border-t"><td colspan="3" class="px-4 py-3 text-right font-bold">Total:</td><td class="px-4 py-3 text-right font-bold text-blue-600">${{ number_format($order->total, 2) }}</td></tr></tfoot></table></div>
            <div class="flex justify-between gap-4 mt-8"><a href="/products" class="bg-blue-600 text-white px-6 py-3 rounded-lg text-center"><i class="fas fa-shopping"></i> Continue Shopping</a><button onclick="window.print()" class="bg-gray-600 text-white px-6 py-3 rounded-lg"><i class="fas fa-print"></i> Print Receipt</button></div>
        </div>
    </div>
</div>
<style media="print">header,footer,.btn,button{display:none !important}body{background:white}</style>
@endsection