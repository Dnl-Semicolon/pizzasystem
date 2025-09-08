<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Figtree', sans-serif;
        }
        .mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .payment-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-bottom: 1px solid rgba(116, 75, 162, 0.2);
        }
        .purple-button {
            background: linear-gradient(45deg, #667eea, #764ba2);
            transition: all 0.2s ease;
            font-family: 'JetBrains Mono', monospace;
        }
        .purple-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(116, 75, 162, 0.3);
            background: linear-gradient(45deg, #5a67d8, #6b46c1);
        }
        .purple-button:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Header -->
        <div class="payment-header">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-pizza-slice text-white text-2xl"></i>
                        @auth
                            <a href="{{ route('billing.index') }}" 
                               class="text-xl font-bold text-white hover:text-purple-200 mono transition-colors duration-200 hover:underline">
                                {{ config('app.name') }} Payment
                            </a>
                        @else
                            <h1 class="text-xl font-bold text-white mono">{{ config('app.name') }} Payment</h1>
                        @endauth
                    </div>

                    @auth
                        <div class="flex items-center space-x-3 text-white">
                            @if(Auth::user()->profile_photo_path && file_exists(public_path(Auth::user()->profile_photo_path)))
                                <img src="{{ asset(Auth::user()->profile_photo_path) }}"
                                     alt="{{ Auth::user()->name }}"
                                     class="w-8 h-8 rounded-full object-cover border-2 border-white/20">
                            @else
                                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                            @endif
                            <div class="text-sm">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                                <div class="text-purple-200 text-xs mono">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Page Heading -->
        @isset($header)
            <div class="py-8 bg-gray-50 border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-gray-900 mono">
                            {{ $header }}
                        </h2>
                        <div class="mt-2 flex items-center justify-center space-x-4 text-sm text-gray-600">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-shield-alt text-green-500"></i>
                                <span>Secure Payment</span>
                            </div>
                            {{--<div class="w-1 h-1 bg-gray-400 rounded-full"></div>
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-lock text-blue-500"></i>
                                <span>SSL Encrypted</span>
                            </div>
                            <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-certificate text-purple-500"></i>
                                <span>PCI Compliant</span>
                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        @endisset

        <!-- Page Content -->
        <main class="pb-12">
            {{ $slot }}
        </main>

        <!-- Simple Footer -->
        <footer class="bg-gray-50 border-t border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <a href="{{ route('home') }}" class="hover:text-purple-600 transition-colors">
                            <i class="fas fa-home mr-1"></i>Home
                        </a>
                        <a href="{{ route('profile.edit') }}" class="hover:text-purple-600 transition-colors">
                            <i class="fas fa-user mr-1"></i>Profile
                        </a>
                        @auth
                            <a href="{{ route('billing.index') }}" class="hover:text-purple-600 transition-colors">
                                <i class="fas fa-receipt mr-1"></i>Billing
                            </a>
                        @endauth
                    </div>
                    <div class="text-sm text-gray-500 mono">
                        © {{ date('Y') }} {{ config('app.name') }} Payment System
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
