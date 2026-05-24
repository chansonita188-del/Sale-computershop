@extends('layouts.app')

@section('title', 'Login - Sale ComputerShop')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8 transform transition hover:scale-105">
        <div class="text-center mb-8">
            <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-laptop-code text-4xl text-blue-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Welcome Back!</h2>
            <p class="text-gray-500 mt-2">Sign in to your Sale ComputerShop account</p>
        </div>
        
        <form method="POST" action="/login" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" required 
                           class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="your@email.com">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password" required 
                           class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="••••••••">
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition transform hover:scale-105">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-gray-600">Don't have an account? 
                <a href="/register" class="text-blue-600 font-semibold hover:underline">Create Account</a>
            </p>
        </div>
        
        <div class="mt-8 pt-6 border-t text-center">
            <p class="text-xs text-gray-500">Demo Admin: admin@salecs.com / admin123</p>
            <p class="text-xs text-gray-500">Demo Customer: customer@test.com / customer123</p>
        </div>
    </div>
</div>
@endsection