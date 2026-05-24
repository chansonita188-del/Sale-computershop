@extends('layouts.app')

@section('title', 'Register - Sale ComputerShop')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8 transform transition hover:scale-105">
        <div class="text-center mb-8">
            <div class="bg-green-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-4xl text-green-600"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Create Account</h2>
            <p class="text-gray-500 mt-2">Join Sale ComputerShop today</p>
        </div>
        
        <form method="POST" action="/register" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="name" required 
                           class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                           placeholder="Your Full Name">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" required 
                           class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                           placeholder="your@email.com">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password" required 
                           class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                           placeholder="••••••••">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="password" name="password_confirmation" required 
                           class="pl-10 w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                           placeholder="Confirm password">
                </div>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition transform hover:scale-105">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-gray-600">Already have an account? 
                <a href="/login" class="text-blue-600 font-semibold hover:underline">Sign In</a>
            </p>
        </div>
    </div>
</div>
@endsection