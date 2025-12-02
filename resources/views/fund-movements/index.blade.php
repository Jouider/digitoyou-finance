<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fonds Personnel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    <i class="fas fa-wallet text-blue-600"></i>
                    Fonds Personnel
                </h1>
                <p class="text-gray-600 mt-2">Gestion des fonds personnels et de l'agence</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i> Retour
                </a>
                <a href="{{ route('fund-movements.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i> Nouveau Mouvement
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Balances Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Abdellah Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Abdellah</h3>
                        <p class="text-sm text-gray-500">Fonds personnel</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold {{ $balances['abdellah'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($balances['abdellah'], 2) }} DH
                </div>
                <button onclick="openTransferModal('abdellah')" 
                        class="mt-4 w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                    <i class="fas fa-exchange-alt mr-2"></i> Verser vers agence
                </button>
            </div>

            <!-- Mouad Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Mouad</h3>
                        <p class="text-sm text-gray-500">Fonds personnel</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-user text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold {{ $balances['mouad'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($balances['mouad'], 2) }} DH
                </div>
                <button onclick="openTransferModal('mouad')" 
                        class="mt-4 w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">
                    <i class="fas fa-exchange-alt mr-2"></i> Verser vers agence
                </button>
            </div>

            <!-- Agency Card -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Agence</h3>
                        <p class="text-sm text-gray-500">Fonds commun</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-building text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="text-3xl font-bold {{ $balances['agency'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($balances['agency'], 2) }} DH
                </div>
                <div class="mt-4 text-sm text-gray-600">
                    <i class="fas fa-info-circle mr-2"></i> Fonds collectif
                </div>
            </div>
        </div>

        <!-- Movements List -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-history text-gray-600 mr-2"></i>
                    Historique des Mouvements
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Personne</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lié à</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($movements as $movement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $movement->movement_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($movement->person === 'abdellah')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <i class="fas fa-user mr-1"></i> Abdellah
                                        </span>
                                    @elseif($movement->person === 'mouad')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-user mr-1"></i> Mouad
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <i class="fas fa-building mr-1"></i> Agence
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($movement->type === 'entree')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-arrow-down mr-1"></i> Entrée
                                        </span>
                                    @elseif($movement->type === 'sortie')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            <i class="fas fa-arrow-up mr-1"></i> Sortie
                                        </span>
                                    @elseif($movement->type === 'distribution')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-coins mr-1"></i> Distribution
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            <i class="fas fa-exchange-alt mr-1"></i> Vers agence
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $movement->description }}
                                    @if($movement->notes)
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($movement->notes, 50) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ in_array($movement->type, ['entree', 'distribution']) ? 'text-green-600' : 'text-red-600' }}">
                                    {{ in_array($movement->type, ['entree', 'distribution']) ? '+' : '-' }}{{ number_format($movement->amount, 2) }} DH
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if($movement->projectPayment)
                                        <span class="text-blue-600">
                                            <i class="fas fa-project-diagram mr-1"></i>
                                            {{ $movement->projectPayment->project->name }}
                                        </span>
                                    @elseif($movement->expense)
                                        <span class="text-red-600">
                                            <i class="fas fa-receipt mr-1"></i>
                                            {{ $movement->expense->name }}
                                        </span>
                                    @elseif($movement->profitDistribution)
                                        <span class="text-yellow-600">
                                            <i class="fas fa-chart-pie mr-1"></i>
                                            Distribution
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('fund-movements.show', $movement) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('fund-movements.edit', $movement) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('fund-movements.destroy', $movement) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce mouvement ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3"></i>
                                    <p>Aucun mouvement de fonds enregistré</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($movements->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $movements->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Transfer Modal -->
    <div id="transferModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Verser vers Agence</h3>
                <button onclick="closeTransferModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="{{ route('fund-movements.transfer') }}" method="POST">
                @csrf
                <input type="hidden" name="from_person" id="from_person">
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">De:</label>
                    <div class="bg-gray-100 p-3 rounded" id="from_person_display"></div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Solde disponible:</label>
                    <div class="bg-blue-50 p-3 rounded text-lg font-semibold text-blue-600" id="available_balance"></div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Montant à verser:</label>
                    <input type="number" name="amount" step="0.01" min="0" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Notes (optionnel):</label>
                    <textarea name="notes" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeTransferModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <i class="fas fa-exchange-alt mr-2"></i> Effectuer le versement
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const balances = {
            abdellah: {{ $balances['abdellah'] }},
            mouad: {{ $balances['mouad'] }}
        };

        function openTransferModal(person) {
            document.getElementById('from_person').value = person;
            document.getElementById('from_person_display').textContent = person.charAt(0).toUpperCase() + person.slice(1);
            document.getElementById('available_balance').textContent = balances[person].toFixed(2) + ' DH';
            document.getElementById('transferModal').classList.remove('hidden');
        }

        function closeTransferModal() {
            document.getElementById('transferModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('transferModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTransferModal();
            }
        });
    </script>
</body>
</html>
