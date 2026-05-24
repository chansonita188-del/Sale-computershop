<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Display shopping cart
    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('orders.cart', compact('cart', 'total'));
    }
    
    // Add product to cart
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'price' => $product->price,
                'specs' => $product->full_specs ?? $product->specifications,
                'quantity' => 1,
                'image' => $product->image_url,
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', "{$product->name} added to cart!");
    }
    
    // Update cart quantities
    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        if ($request->has('quantities')) {
            foreach ($request->quantities as $id => $quantity) {
                if ($quantity <= 0) {
                    unset($cart[$id]);
                } else {
                    $cart[$id]['quantity'] = $quantity;
                }
            }
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cart updated successfully!');
    }
    
    // Remove item from cart
    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item removed from cart!');
        }
        return redirect()->back()->with('error', 'Item not found in cart!');
    }
    
    // Update cart with customer information (modal popup)
    public function updateCartWithInfo(Request $request)
    {
        // Validate customer information
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'alt_phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:500',
            'instructions' => 'nullable|string',
            'cart_number' => 'required|string',
        ]);
        
        // Save customer info to session
        session()->put('customer_info', [
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'alt_phone' => $validated['alt_phone'] ?? '',
            'address' => $validated['address'],
            'instructions' => $validated['instructions'] ?? '',
            'cart_number' => $validated['cart_number'],
        ]);
        
        // Get current cart
        $cart = session()->get('cart', []);
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = $subtotal * 0.10;
        $shipping = $subtotal > 50 ? 0 : 10.00;
        $total = $subtotal + $tax + $shipping;
        
        // Store cart summary in session
        session()->put('cart_summary', [
            'cart_number' => $validated['cart_number'],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
            'items_count' => count($cart),
        ]);
        
        return redirect()->route('cart')->with('success', 'Cart updated successfully! Customer information saved.');
    }
    
    // Save customer information only
    public function saveCustomerInfo(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string',
        ]);
        
        session()->put('customer_info', [
            'name' => $validated['customer_name'],
            'email' => $validated['customer_email'],
            'phone' => $validated['customer_phone'],
            'address' => $validated['shipping_address'],
            'notes' => $validated['notes'] ?? '',
        ]);
        
        return redirect()->back()->with('success', 'Customer information saved!');
    }
    
    // Save customer info and redirect to checkout
    public function saveAndCheckout(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string',
        ]);
        
        session()->put('customer_info', [
            'name' => $validated['customer_name'],
            'email' => $validated['customer_email'],
            'phone' => $validated['customer_phone'],
            'address' => $validated['shipping_address'],
            'notes' => $validated['notes'] ?? '',
        ]);
        
        return redirect()->route('checkout');
    }
    
    // Display checkout page
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty!');
        }
        
        // Get customer info from session
        $customerInfo = session()->get('customer_info', []);
        
        // If no customer info, redirect to cart to fill info
        if (empty($customerInfo)) {
            return redirect()->route('cart')->with('error', 'Please provide your information before checkout.');
        }
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = $subtotal * 0.10;
        $shipping = $subtotal > 50 ? 0 : 10.00;
        $total = $subtotal + $tax + $shipping;
        
        return view('orders.checkout', compact('cart', 'subtotal', 'tax', 'shipping', 'total', 'customerInfo'));
    }
    
    // Place order
    public function placeOrder(Request $request)
    {
        // Get saved customer info from session
        $customerInfo = session()->get('customer_info', []);
        
        // Use saved info if not provided in request
        $customerName = $request->customer_name ?? $customerInfo['name'] ?? '';
        $customerEmail = $request->customer_email ?? $customerInfo['email'] ?? '';
        $customerPhone = $request->customer_phone ?? $customerInfo['phone'] ?? '';
        $shippingAddress = $request->shipping_address ?? $customerInfo['address'] ?? '';
        $notes = $request->notes ?? $customerInfo['instructions'] ?? $customerInfo['notes'] ?? '';
        
        $request->merge([
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'customer_phone' => $customerPhone,
            'shipping_address' => $shippingAddress,
            'notes' => $notes,
        ]);
        
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'shipping_address' => 'required|string',
        ]);
        
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Cart is empty!');
        }
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = $subtotal * 0.10;
        $shipping = $subtotal > 50 ? 0 : 10.00;
        $total = $subtotal + $tax + $shipping;
        
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shipping,
                'total' => $total,
                'payment_method' => $request->payment_method ?? 'cash_on_delivery',
                'status' => 'pending',
                'notes' => $request->notes,
            ]);
            
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'product_specs' => $item['specs'] ?? '',
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
                
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }
            
            // Clear cart and customer info from session
            session()->forget('cart');
            session()->forget('customer_info');
            session()->forget('cart_summary');
            DB::commit();
            
            return redirect()->route('orders.receipt', $order)->with('success', 'Order placed successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }
    
    // Display order receipt
    public function receipt(Order $order)
    {
        $order->load('items');
        return view('orders.receipt', compact('order'));
    }
    
    // Display customer's orders
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('orders.my-orders', compact('orders'));
    }
    
    // Admin: View all orders
    public function adminOrders()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        $orders = Order::with('items')->latest()->paginate(20);
        return view('admin.orders', compact('orders'));
    }
    
    // Admin: Update order status
    public function updateOrderStatus(Request $request, Order $order)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Order status updated!');
    }
    
    // Get cart summary as JSON
    public function getCartSummary()
    {
        $cart = session()->get('cart', []);
        $customerInfo = session()->get('customer_info', []);
        $cartSummary = session()->get('cart_summary', []);
        
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'customer_info' => $customerInfo,
            'summary' => $cartSummary,
        ]);
    }
}