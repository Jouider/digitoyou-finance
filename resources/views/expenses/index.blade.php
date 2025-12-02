@extends('layouts.app')

@section('title', 'Charges')
@section('page-title', 'Gestion des Charges')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Suivi des dépenses de l'agence (abonnements, matériel, logiciels)</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nouvelle Charge
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm mb-1">Charges Mensuelles</p>
                    <p class="text-3xl font-bold">
                        {{ number_format($expenses->where('status', 'actif')->where('frequency', 'mensuel')->sum('amount'), 0) }} DH
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-calendar text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm mb-1">Charges Annuelles</p>
                    <p class="text-3xl font-bold">
                        {{ number_format($expenses->where('status', 'actif')->where('frequency', 'annuel')->sum('amount'), 0) }} DH
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-calendar-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Charges Uniques</p>
                    <p class="text-3xl font-bold">
                        {{ number_format($expenses->where('frequency', 'unique')->sum('amount'), 0) }} DH
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Total Mensuel Estimé</p>
                    <p class="text-3xl font-bold">
                        {{ number_format(
                            $expenses->where('status', 'actif')->sum(function($expense) {
                                if ($expense->frequency === 'mensuel') return $expense->amount;
                                if ($expense->frequency === 'annuel') return $expense->amount / 12;
                                return 0;
                            }), 0
                        ) }} DH
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-calculator text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex flex-wrap gap-4">
            <button onclick="filterExpenses('all')" class="filter-btn active px-4 py-2 rounded-lg transition" data-filter="all">
                <i class="fas fa-list mr-2"></i>Toutes
            </button>
            <button onclick="filterExpenses('mensuel')" class="filter-btn px-4 py-2 rounded-lg transition" data-filter="mensuel">
                <i class="fas fa-calendar mr-2"></i>Mensuelles
            </button>
            <button onclick="filterExpenses('annuel')" class="filter-btn px-4 py-2 rounded-lg transition" data-filter="annuel">
                <i class="fas fa-calendar-alt mr-2"></i>Annuelles
            </button>
            <button onclick="filterExpenses('unique')" class="filter-btn px-4 py-2 rounded-lg transition" data-filter="unique">
                <i class="fas fa-shopping-cart mr-2"></i>Uniques
            </button>
            <button onclick="filterExpenses('actif')" class="filter-btn px-4 py-2 rounded-lg transition" data-filter="actif">
                <i class="fas fa-check-circle mr-2"></i>Actives
            </button>
            <button onclick="filterExpenses('inactif')" class="filter-btn px-4 py-2 rounded-lg transition" data-filter="inactif">
                <i class="fas fa-times-circle mr-2"></i>Inactives
            </button>
        </div>
    </div>

    <!-- Liste des charges -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Charge</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fréquence</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coût/Mois</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prochain Paiement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($expenses as $expense)
                        <tr class="hover:bg-gray-50 expense-row" data-frequency="{{ $expense->frequency }}" data-status="{{ $expense->status }}">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $expense->name }}</div>
                                @if($expense->description)
                                    <div class="text-xs text-gray-500 mt-1">{{ Str::limit($expense->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($expense->type === 'abonnement') bg-blue-100 text-blue-800
                                    @elseif($expense->type === 'hebergement') bg-indigo-100 text-indigo-800
                                    @elseif($expense->type === 'domaine') bg-cyan-100 text-cyan-800
                                    @elseif($expense->type === 'materiel') bg-green-100 text-green-800
                                    @elseif($expense->type === 'logiciel') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($expense->type === 'abonnement')
                                        <i class="fas fa-sync-alt mr-1"></i> Abonnement
                                    @elseif($expense->type === 'hebergement')
                                        <i class="fas fa-server mr-1"></i> Hébergement
                                    @elseif($expense->type === 'domaine')
                                        <i class="fas fa-globe mr-1"></i> Domaine
                                    @elseif($expense->type === 'materiel')
                                        <i class="fas fa-laptop mr-1"></i> Matériel
                                    @elseif($expense->type === 'logiciel')
                                        <i class="fas fa-code mr-1"></i> Logiciel
                                    @else
                                        <i class="fas fa-file mr-1"></i> Autre
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ number_format($expense->amount, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm capitalize
                                    @if($expense->frequency === 'mensuel') text-red-600
                                    @elseif($expense->frequency === 'annuel') text-orange-600
                                    @else text-purple-600
                                    @endif">
                                    @if($expense->frequency === 'mensuel')
                                        <i class="fas fa-calendar mr-1"></i>
                                    @elseif($expense->frequency === 'annuel')
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                    @else
                                        <i class="fas fa-shopping-cart mr-1"></i>
                                    @endif
                                    {{ $expense->frequency }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                @if($expense->frequency === 'mensuel')
                                    {{ number_format($expense->amount, 2) }} DH
                                @elseif($expense->frequency === 'annuel')
                                    {{ number_format($expense->amount / 12, 2) }} DH
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($expense->next_expense_date && $expense->status === 'actif')
                                    <span class="text-gray-900">{{ $expense->next_expense_date->format('d/m/Y') }}</span>
                                    @if($expense->next_expense_date->isPast())
                                        <span class="ml-2 text-red-600 text-xs">
                                            <i class="fas fa-exclamation-triangle"></i> En retard
                                        </span>
                                    @elseif($expense->next_expense_date->diffInDays(now()) <= 7)
                                        <span class="ml-2 text-yellow-600 text-xs">
                                            <i class="fas fa-clock"></i> Bientôt
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($expense->status === 'actif') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($expense->status === 'actif')
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    @else
                                        <i class="fas fa-times-circle mr-1"></i> Inactive
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2 whitespace-nowrap">
                                <a href="{{ route('expenses.show', $expense) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('expenses.edit', $expense) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette charge ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-receipt text-4xl mb-4"></i>
                                    <p class="text-lg">Aucune charge enregistrée</p>
                                    <p class="text-sm mt-2">Commencez par ajouter vos abonnements et dépenses</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Résumé des coûts annuels -->
    @if($expenses->where('status', 'actif')->count() > 0)
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">💰 Projection Annuelle</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-indigo-100 text-sm mb-1">Coût Total Annuel</p>
                    <p class="text-3xl font-bold">
                        {{ number_format(
                            $expenses->where('status', 'actif')->sum(function($expense) {
                                if ($expense->frequency === 'mensuel') return $expense->amount * 12;
                                if ($expense->frequency === 'annuel') return $expense->amount;
                                return 0;
                            }), 2
                        ) }} DH
                    </p>
                </div>
                <div>
                    <p class="text-indigo-100 text-sm mb-1">Moyenne Mensuelle</p>
                    <p class="text-3xl font-bold">
                        {{ number_format(
                            $expenses->where('status', 'actif')->sum(function($expense) {
                                if ($expense->frequency === 'mensuel') return $expense->amount;
                                if ($expense->frequency === 'annuel') return $expense->amount / 12;
                                return 0;
                            }), 2
                        ) }} DH
                    </p>
                </div>
                <div>
                    <p class="text-indigo-100 text-sm mb-1">Charges Actives</p>
                    <p class="text-3xl font-bold">
                        {{ $expenses->where('status', 'actif')->count() }}
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function filterExpenses(filter) {
    const rows = document.querySelectorAll('.expense-row');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Update active button
    buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-blue-600', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-700');
        if (btn.dataset.filter === filter) {
            btn.classList.add('active', 'bg-blue-600', 'text-white');
            btn.classList.remove('bg-gray-100', 'text-gray-700');
        }
    });
    
    // Filter rows
    rows.forEach(row => {
        if (filter === 'all') {
            row.style.display = '';
        } else if (filter === 'actif' || filter === 'inactif') {
            row.style.display = row.dataset.status === filter ? '' : 'none';
        } else {
            row.style.display = row.dataset.frequency === filter ? '' : 'none';
        }
    });
}

// Initialize active button style
document.addEventListener('DOMContentLoaded', function() {
    const activeBtn = document.querySelector('.filter-btn.active');
    if (activeBtn) {
        activeBtn.classList.add('bg-blue-600', 'text-white');
        activeBtn.classList.remove('bg-gray-100', 'text-gray-700');
    }
});
</script>

<style>
.filter-btn {
    background-color: #f3f4f6;
    color: #374151;
}
.filter-btn.active {
    background-color: #2563eb;
    color: white;
}
</style>
@endpush
@endsection
