<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Finance Agence Digitale')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-900 to-blue-700 text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold mb-8">💰 Finance Agence</h1>
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('dashboard') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-chart-line mr-3"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('clients.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('clients.*') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-users mr-3"></i>
                        Clients
                    </a>
                    <a href="{{ route('projects.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('projects.*') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-folder mr-3"></i>
                        Projets
                    </a>
                    <a href="{{ route('project-payments.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('project-payments.*') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-money-bill-wave mr-3"></i>
                        Paiements Clients
                    </a>
                    <a href="{{ route('expenses.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('expenses.*') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-receipt mr-3"></i>
                        Charges
                    </a>
                    <a href="{{ route('profit-distributions.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('profit-distributions.*') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-hand-holding-usd mr-3"></i>
                        Répartition
                    </a>
                    <a href="{{ route('fund-movements.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('fund-movements.*') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-wallet mr-3"></i>
                        Fonds Personnel
                    </a>
                    <a href="{{ route('annual-report') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('annual-report') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-chart-line mr-3"></i>
                        Rapport Annuel
                    </a>
                    <a href="{{ route('backup.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-800 transition {{ request()->routeIs('backup.*') ? 'bg-blue-800' : '' }}">
                        <i class="fas fa-download mr-3"></i>
                        Sauvegarde
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm">
                <div class="px-8 py-4 flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title')</h2>
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">
                            <i class="fas fa-user-circle mr-2"></i>{{ Auth::user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            
            <div class="p-8">
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

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
