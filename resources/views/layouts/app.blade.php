<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sale ComputerShop - Premium Computers')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Header / Navigation -->
    <header class="bg-gradient-to-r from-blue-900 to-purple-900 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center flex-wrap gap-4">
                <!-- Logo -->
                <a href="/" class="text-2xl font-bold flex items-center gap-2 group">
                    <i class="fas fa-laptop-code text-blue-400 group-hover:scale-110 transition"></i>
                    <span>Sale<span class="text-blue-400">ComputerShop</span></span>
                </a>
                
                <!-- Navigation -->
                <nav class="flex gap-4 flex-wrap">
                    <a href="/" class="hover:text-blue-300 transition"><i class="fas fa-home"></i> Home</a>
                    <a href="/products" class="hover:text-blue-300 transition"><i class="fas fa-laptop"></i> Products</a>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="/admin/products/create" class="bg-green-600 px-3 py-1 rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-plus-circle"></i> Add Computer
                            </a>
                            <a href="/admin/orders" class="bg-purple-600 px-3 py-1 rounded-lg hover:bg-purple-700 transition">
                                <i class="fas fa-truck"></i> Manage Orders
                            </a>
                        @endif
                        <a href="/my-orders" class="hover:text-blue-300 transition"><i class="fas fa-receipt"></i> My Orders</a>
                    @endauth
                </nav>
                
                <!-- User Menu & Cart -->
                <div class="flex gap-4 items-center">
                    <a href="/cart" class="relative hover:text-blue-300 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @php $cartCount = count(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs rounded-full px-1.5 animate-pulse">{{ $cartCount }}</span>
                        @endif
                    </a>
                    
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2 bg-blue-800 px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-56 bg-white text-gray-800 rounded-lg shadow-xl hidden group-hover:block z-50">
                                <div class="px-4 py-3 border-b bg-gray-50 rounded-t-lg">
                                    <p class="font-semibold">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    <p class="text-xs mt-1">
                                        @if(Auth::user()->isAdmin())
                                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Administrator</span>
                                        @else
                                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Customer</span>
                                        @endif
                                    </p>
                                </div>
                                @if(Auth::user()->isAdmin())
                                    <a href="/admin/products/create" class="block px-4 py-2 hover:bg-gray-100 text-green-600">
                                        <i class="fas fa-plus"></i> Add New Product
                                    </a>
                                    <a href="/admin/orders" class="block px-4 py-2 hover:bg-gray-100 text-purple-600">
                                        <i class="fas fa-truck"></i> Manage Orders
                                    </a>
                                @endif
                                <a href="/my-orders" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-receipt"></i> My Orders
                                </a>
                                <form method="POST" action="/logout" class="border-t">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="/register" class="bg-green-600 px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 max-w-7xl min-h-[calc(100vh-200px)]">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow animate-bounce">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-laptop-code text-blue-400"></i>
                        Sale<span class="text-blue-400">ComputerShop</span>
                    </h3>
                    <p class="text-gray-400 text-sm">Your trusted source for premium computer components and systems since 2024.</p>
                    <div class="flex gap-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-blue-400"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="/" class="hover:text-blue-400">Home</a></li>
                        <li><a href="/products" class="hover:text-blue-400">Products</a></li>
                        <li><a href="/cart" class="hover:text-blue-400">Cart</a></li>
                        @auth
                            <li><a href="/my-orders" class="hover:text-blue-400">My Orders</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">Categories</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="/products?category=laptops" class="hover:text-blue-400">Laptops</a></li>
                        <li><a href="/products?category=desktops" class="hover:text-blue-400">Desktops</a></li>
                        <li><a href="/products?category=components" class="hover:text-blue-400">Components</a></li>
                        <li><a href="/products?category=gaming" class="hover:text-blue-400">Gaming PCs</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">Contact</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><i class="fas fa-envelope"></i> support@salecomputershop.com</li>
                        <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Tech Street, Digital City</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; 2024 Sale ComputerShop. All rights reserved. | Designed for computer enthusiasts</p>
            </div>
        </div>
    </footer>
</body>
</html>