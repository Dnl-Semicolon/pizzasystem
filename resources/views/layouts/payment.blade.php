<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Payment') - Pizza System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .payment-card { backdrop-filter: blur(10px); }
        .shimmer { animation: shimmer 2s infinite; }
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .payment-method-card:hover { transform: translateY(-2px); }
        .payment-method-card { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 to-red-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <header class="mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">🍕 Pizza Payment</h1>
                <p class="text-gray-600">Secure and seamless checkout experience</p>
            </div>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="mt-12 text-center">
            <p class="text-sm text-gray-500">
                🔒 Your payment is secured with industry-standard encryption
            </p>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>