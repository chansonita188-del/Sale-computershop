@extends('layouts.app')

@section('title', 'My Orders - Sale ComputerShop')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6"><i class="fas fa-receipt text-blue-600"></i> My Orders</h1>
    @if($orders->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <table class="min-w-full"><thead class="bg-gray-800 text-white"><tr><th class="px-6 py-3 text-left">Order #</th><th class="px-6 py-3 text-left">Date</th><th class="px-6 py-3 text-center">Items</th><th class="px-6 py-3 text-right">Total</th><th class="px-6 py-3 text-center">Status</th><th class="px-6 py-3 text-center">Action</th></tr></thead>
            <tbody>@foreach($orders as $order)<tr class="border-b hover:bg-gray-50"><td class="px-6 py-4 font-mono text-sm">{{ $order->order_number }}</td><td class="px-6 py-4">{{ $order->created_at->format('M d, Y') }}</td><td class="px-6 py-4 text-center">{{ $order->items->sum('quantity') }}</td><td class="px-6 py-4 font-bold">${{ number_format($order->total, 2) }}</td><td class="px-6 py-4"><span class="px-2 py-1 rounded-full text-xs font-semibold {{ $order->status_badge }}">{{ ucfirst($order->status) }}</span></td><td class="px-6 py-4"><a href="/order/receipt/{{ $order->id }}" class="text-blue-600">View</a></td></tr>@endforeach</tbody></table>
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center"><i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i><h2 class="text-2xl font-bold text-gray-600 mb-2">No Orders Yet</h2><p class="text-gray-500 mb-6">You haven't placed any orders yet.</p><a href="/products" class="bg-blue-600 text-white px-6 py-3 rounded-lg"><i class="fas fa-shopping"></i> Start Shopping</a></div>
    @endif
</div>
@endsection