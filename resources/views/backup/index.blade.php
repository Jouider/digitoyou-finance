<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sauvegarde & Restauration - Finance DigiToYou</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-blue-600 text-white p-4 shadow-lg">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <h1 class="text-2xl font-bold">💾 Sauvegarde & Restauration</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-200">
                        <i class="fas fa-arrow-left"></i> Retour au tableau de bord
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-blue-200">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container mx-auto px-4 py-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Export Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 text-blue-600">
                        <i class="fas fa-download"></i> Exporter les données
                    </h2>
                    <p class="text-gray-600 mb-6">
                        Téléchargez une copie de toutes vos données (clients, projets, dépenses, paiements, etc.)
                    </p>

                    <div class="space-y-4">
                        <!-- Export JSON -->
                        <form action="{{ route('backup.export') }}" method="GET">
                            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                                <i class="fas fa-file-code mr-2"></i> Télécharger (Format JSON)
                            </button>
                        </form>

                        <!-- Export SQLite -->
                        <form action="{{ route('backup.export.sql') }}" method="GET">
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                                <i class="fas fa-database mr-2"></i> Télécharger (Base SQLite)
                            </button>
                        </form>
                    </div>

                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h3 class="font-semibold text-blue-800 mb-2">
                            <i class="fas fa-info-circle"></i> Informations
                        </h3>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li><i class="fas fa-check text-green-500"></i> Format JSON: Facile à lire et compatible</li>
                            <li><i class="fas fa-check text-green-500"></i> Format SQLite: Base complète pour backup</li>
                            <li><i class="fas fa-check text-green-500"></i> Conservez vos fichiers en lieu sûr</li>
                        </ul>
                    </div>
                </div>

                <!-- Import Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 text-orange-600">
                        <i class="fas fa-upload"></i> Importer les données
                    </h2>
                    <p class="text-gray-600 mb-6">
                        Restaurez vos données à partir d'un fichier de sauvegarde JSON
                    </p>

                    <form action="{{ route('backup.import') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('⚠️ ATTENTION: Cela va remplacer toutes les données actuelles (sauf les utilisateurs). Continuer?');">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold mb-2">
                                <i class="fas fa-file-upload"></i> Fichier de sauvegarde (JSON)
                            </label>
                            <input 
                                type="file" 
                                name="backup_file" 
                                accept=".json"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            >
                            @error('backup_file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <i class="fas fa-cloud-upload-alt mr-2"></i> Restaurer les données
                        </button>
                    </form>

                    <div class="mt-6 p-4 bg-red-50 rounded-lg border-l-4 border-red-500">
                        <h3 class="font-semibold text-red-800 mb-2">
                            <i class="fas fa-exclamation-triangle"></i> Attention
                        </h3>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li><i class="fas fa-times text-red-500"></i> Remplace toutes les données actuelles</li>
                            <li><i class="fas fa-shield-alt text-green-500"></i> Les utilisateurs sont préservés</li>
                            <li><i class="fas fa-save text-blue-500"></i> Exportez d'abord si nécessaire</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">
                    <i class="fas fa-chart-bar"></i> Statistiques actuelles
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600">{{ \App\Models\Client::count() }}</div>
                        <div class="text-sm text-gray-600">Clients</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-3xl font-bold text-green-600">{{ \App\Models\Project::count() }}</div>
                        <div class="text-sm text-gray-600">Projets</div>
                    </div>
                    <div class="text-center p-4 bg-red-50 rounded-lg">
                        <div class="text-3xl font-bold text-red-600">{{ \App\Models\Expense::count() }}</div>
                        <div class="text-sm text-gray-600">Dépenses</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-3xl font-bold text-purple-600">{{ \App\Models\ProjectPayment::count() }}</div>
                        <div class="text-sm text-gray-600">Paiements</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-3xl font-bold text-yellow-600">{{ \App\Models\ProfitDistribution::count() }}</div>
                        <div class="text-sm text-gray-600">Distributions</div>
                    </div>
                    <div class="text-center p-4 bg-indigo-50 rounded-lg">
                        <div class="text-3xl font-bold text-indigo-600">{{ \App\Models\FundMovement::count() }}</div>
                        <div class="text-sm text-gray-600">Mouvements</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
