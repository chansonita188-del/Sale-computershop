@extends('layouts.app')

@section('title', 'Manage Orders - Admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold"><i class="fas fa-truck"></i> Manage Orders</h1>
</div>
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-800 text-white">
                <tr><th class="px-4 py-3">Order #</th><th class="px-4 py-3">Customer</th><th class="px-4 py-3">Items</th><th class="px-4 py-3 text-right">Total</th><th class="px-4 py-3 text-center">Status</th><th class="px-4 py-3 text-center">Action</th></tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-sm">{{ $order->order_number }}</td>
                    <td class="px-4 py-3">{{ $order->customer_name }}<br><span class="text-xs text-gray-500">{{ $order->customer_email }}</span></td>
                    <td class="px-4 py-3 text-center">{{ $order->items->sum('quantity') }}</td>
                    <td class="px-4 py-3 text-right font-bold">${{ number_format($order->total, 2) }}</td>
                    <td class="px-4 py-3 text-center">
                        <form action="/admin/orders/{{ $order->id }}/status" method="POST">
                            @csrf
                            <select name="status" onchange="this.form.submit()" class="text-sm border rounded px-2 py-1">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-center"><a href="/order/receipt/{{ $order->id }}" class="text-blue-600"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $orders->links() }}</div>
@endsection