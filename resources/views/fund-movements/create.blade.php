<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Mouvement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="flex items-center mb-8">
            <a href="{{ route('fund-movements.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-plus-circle text-blue-600"></i>
                    Nouveau Mouvement de Fonds
                </h1>
                <p class="text-gray-600 mt-1">Enregistrer un nouveau mouvement de fonds</p>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fund-movements.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Person Selection -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-3">
                        <i class="fas fa-user mr-2"></i>Personne *
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <input type="radio" name="person" value="abdellah" required class="mr-3 w-5 h-5">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <span class="font-semibold">Abdellah</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition">
                            <input type="radio" name="person" value="mouad" required class="mr-3 w-5 h-5">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                <span class="font-semibold">Mouad</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 transition">
                            <input type="radio" name="person" value="agency" required class="mr-3 w-5 h-5">
                            <div class="flex items-center">
                                <div class="bg-purple-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-building text-purple-600"></i>
                                </div>
                                <span class="font-semibold">Agence</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Type Selection -->
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-3">
                        <i class="fas fa-exchange-alt mr-2"></i>Type de Mouvement *
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition">
                            <input type="radio" name="type" value="entree" required class="mr-3 w-5 h-5">
                            <div class="flex items-center">
                                <div class="bg-green-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-arrow-down text-green-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Entrée</div>
                                    <div class="text-xs text-gray-500">Réception d'argent</div>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-500 transition">
                            <input type="radio" name="type" value="sortie" required class="mr-3 w-5 h-5">
                            <div class="flex items-center">
                                <div class="bg-red-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-arrow-up text-red-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Sortie</div>
                                    <div class="text-xs text-gray-500">Paiement d'une charge</div>
                                </div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-yellow-500 transition">
                            <input type="radio" name="type" value="distribution" required class="mr-3 w-5 h-5">
                            <div class="flex items-center">
                                <div class="bg-yellow-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-coins text-yellow-600"></i>
                                </div>
                                <div>
                                    <div class="font-semibold">Distribution</div>
                                    <div class="text-xs text-gray-500">Part de bénéfices</div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Amount and Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-money-bill-wave mr-2"></i>Montant (DH) *
                    </label>
                    <input type="number" name="amount" step="0.01" min="0" value="{{ old('amount') }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        <i class="fas fa-calendar mr-2"></i>Date *
                    </label>
                    <input type="date" name="movement_date" value="{{ old('movement_date', date('Y-m-d')) }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    <i class="fas fa-comment mr-2"></i>Description *
                </label>
                <input type="text" name="description" value="{{ old('description') }}" required 
                       placeholder="Ex: Avance projet X, Paiement hébergement, Part bénéfices novembre..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Relations (Optional) -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-link mr-2"></i>Relations (Optionnel)
                </h3>
                <p class="text-sm text-gray-600 mb-4">Liez ce mouvement à un paiement client, une charge, ou une distribution</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Paiement Client</label>
                        <select name="project_payment_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Aucun --</option>
                            @foreach($projectPayments as $payment)
                                <option value="{{ $payment->id }}">
                                    {{ $payment->project->name }} - {{ number_format($payment->amount, 2) }} DH
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Charge</label>
                        <select name="expense_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Aucune --</option>
                            @foreach($expenses as $expense)
                                <option value="{{ $expense->id }}">
                                    {{ $expense->name }} - {{ number_format($expense->monthly_cost, 2) }} DH
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">ID Distribution</label>
                        <input type="number" name="profit_distribution_id" value="{{ old('profit_distribution_id') }}" 
                               placeholder="ID distribution"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>Notes
                </label>
                <textarea name="notes" rows="4" placeholder="Informations supplémentaires..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes') }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('fund-movements.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    <i class="fas fa-times mr-2"></i>Annuler
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</body>
</html>
