<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventory Management System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-indigo-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <h1 class="text-white text-xl font-bold">IMS</h1>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('dashboard') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-home mr-1"></i> Dashboard
                            </a>
                            <a href="{{ route('items.index') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-box mr-1"></i> Items
                            </a>
                            @if(auth()->check() && auth()->user()->isAdmin())
                            <a href="{{ route('suppliers.index') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-truck mr-1"></i> Suppliers
                            </a>
                            @endif
                            <a href="{{ route('transactions.index') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-exchange-alt mr-1"></i> Transactions
                            </a>
                            <a href="{{ route('reports.inventory') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-chart-bar mr-1"></i> Reports
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @if(auth()->check())
                            <span class="text-white mr-4">{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role->name) }})</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="bg-indigo-800 text-white px-4 py-2 rounded-md hover:bg-indigo-900">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>