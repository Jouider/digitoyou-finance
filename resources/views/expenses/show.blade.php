@extends('layouts.app')

@section('title', 'Détails de la Charge')
@section('page-title', 'Détails de la Charge')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- En-tête avec actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $expense->name }}</h2>
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                        @if($expense->status === 'actif') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        @if($expense->status === 'actif')
                            <i class="fas fa-check-circle mr-1"></i> Active
                        @else
                            <i class="fas fa-times-circle mr-1"></i> Inactive
                        @endif
                    </span>
                </div>
                @if($expense->description)
                    <p class="text-gray-600">{{ $expense->description }}</p>
                @endif
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('expenses.edit', $expense) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette charge ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Informations principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Carte Montant -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-blue-100">Montant de la Charge</h3>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-money-bill-wave text-2xl"></i>
                </div>
            </div>
            <p class="text-4xl font-bold mb-2">{{ number_format($expense->amount, 2) }} DH</p>
            <p class="text-blue-100">
                Fréquence : 
                <span class="capitalize font-semibold">
                    @if($expense->frequency === 'mensuel')
                        <i class="fas fa-calendar mr-1"></i>Mensuelle
                    @elseif($expense->frequency === 'annuel')
                        <i class="fas fa-calendar-alt mr-1"></i>Annuelle
                    @else
                        <i class="fas fa-shopping-cart mr-1"></i>Unique
                    @endif
                </span>
            </p>
        </div>

        <!-- Carte Type -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Type de Charge</h3>
                <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full
                    @if($expense->type === 'abonnement') bg-blue-100 text-blue-800
                    @elseif($expense->type === 'hebergement') bg-indigo-100 text-indigo-800
                    @elseif($expense->type === 'domaine') bg-cyan-100 text-cyan-800
                    @elseif($expense->type === 'materiel') bg-green-100 text-green-800
                    @elseif($expense->type === 'logiciel') bg-purple-100 text-purple-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    @if($expense->type === 'abonnement')
                        <i class="fas fa-sync-alt mr-2"></i> Abonnement
                    @elseif($expense->type === 'hebergement')
                        <i class="fas fa-server mr-2"></i> Hébergement
                    @elseif($expense->type === 'domaine')
                        <i class="fas fa-globe mr-2"></i> Domaine
                    @elseif($expense->type === 'materiel')
                        <i class="fas fa-laptop mr-2"></i> Matériel
                    @elseif($expense->type === 'logiciel')
                        <i class="fas fa-code mr-2"></i> Logiciel
                    @else
                        <i class="fas fa-file mr-2"></i> Autre
                    @endif
                </span>
            </div>
            <div class="space-y-3">
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-calendar w-5 mr-3"></i>
                    <span class="text-sm">Date : {{ $expense->expense_date->format('d/m/Y') }}</span>
                </div>
                @if($expense->next_expense_date && $expense->status === 'actif')
                    <div class="flex items-center text-gray-600">
                        <i class="fas fa-clock w-5 mr-3"></i>
                        <span class="text-sm">Prochain paiement : {{ $expense->next_expense_date->format('d/m/Y') }}</span>
                        @if($expense->next_expense_date->isPast())
                            <span class="ml-2 text-red-600 text-xs font-semibold">
                                <i class="fas fa-exclamation-triangle"></i> En retard
                            </span>
                        @elseif($expense->next_expense_date->diffInDays(now()) <= 7)
                            <span class="ml-2 text-yellow-600 text-xs font-semibold">
                                <i class="fas fa-bell"></i> Bientôt
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Calculs de coûts -->
    @if($expense->frequency !== 'unique')
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                <i class="fas fa-calculator mr-2 text-gray-500"></i>Projection des Coûts
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Coût mensuel -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                    <p class="text-sm text-red-800 mb-1">Coût Mensuel</p>
                    <p class="text-2xl font-bold text-red-900">
                        @if($expense->frequency === 'mensuel')
                            {{ number_format($expense->amount, 2) }}
                        @else
                            {{ number_format($expense->amount / 12, 2) }}
                        @endif
                        DH
                    </p>
                </div>

                <!-- Coût trimestriel -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 border border-yellow-200">
                    <p class="text-sm text-yellow-800 mb-1">Coût Trimestriel</p>
                    <p class="text-2xl font-bold text-yellow-900">
                        @if($expense->frequency === 'mensuel')
                            {{ number_format($expense->amount * 3, 2) }}
                        @else
                            {{ number_format($expense->amount / 4, 2) }}
                        @endif
                        DH
                    </p>
                </div>

                <!-- Coût semestriel -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                    <p class="text-sm text-orange-800 mb-1">Coût Semestriel</p>
                    <p class="text-2xl font-bold text-orange-900">
                        @if($expense->frequency === 'mensuel')
                            {{ number_format($expense->amount * 6, 2) }}
                        @else
                            {{ number_format($expense->amount / 2, 2) }}
                        @endif
                        DH
                    </p>
                </div>

                <!-- Coût annuel -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                    <p class="text-sm text-green-800 mb-1">Coût Annuel</p>
                    <p class="text-2xl font-bold text-green-900">
                        @if($expense->frequency === 'mensuel')
                            {{ number_format($expense->amount * 12, 2) }}
                        @else
                            {{ number_format($expense->amount, 2) }}
                        @endif
                        DH
                    </p>
                </div>
            </div>
        </div>

        <!-- Projection sur 5 ans -->
        <div class="bg-gradient-to-br from-purple-500 to-indigo-600 text-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">
                <i class="fas fa-chart-line mr-2"></i>Projection sur 5 Ans
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Coût Total (5 ans)</p>
                    <p class="text-3xl font-bold">
                        @if($expense->frequency === 'mensuel')
                            {{ number_format($expense->amount * 12 * 5, 2) }}
                        @else
                            {{ number_format($expense->amount * 5, 2) }}
                        @endif
                        DH
                    </p>
                </div>
                <div>
                    <p class="text-purple-100 text-sm mb-1">Moyenne Annuelle</p>
                    <p class="text-3xl font-bold">
                        @if($expense->frequency === 'mensuel')
                            {{ number_format($expense->amount * 12, 2) }}
                        @else
                            {{ number_format($expense->amount, 2) }}
                        @endif
                        DH
                    </p>
                </div>
                <div>
                    <p class="text-purple-100 text-sm mb-1">Paiements Totaux</p>
                    <p class="text-3xl font-bold">
                        @if($expense->frequency === 'mensuel')
                            60
                        @else
                            5
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Pour les charges uniques -->
        <div class="bg-purple-50 border-l-4 border-purple-500 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-shopping-cart text-purple-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-purple-800">Charge Unique</h3>
                    <p class="mt-2 text-sm text-purple-700">
                        Cette charge a été effectuée une seule fois le {{ $expense->expense_date->format('d/m/Y') }}. 
                        Aucun renouvellement n'est prévu.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Métadonnées -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-info-circle mr-2 text-gray-500"></i>Informations Supplémentaires
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="flex items-center text-gray-600">
                <i class="fas fa-calendar-plus w-6 mr-3 text-gray-400"></i>
                <div>
                    <p class="text-gray-500">Date de création</p>
                    <p class="font-medium text-gray-900">{{ $expense->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            @if($expense->updated_at != $expense->created_at)
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-edit w-6 mr-3 text-gray-400"></i>
                    <div>
                        <p class="text-gray-500">Dernière modification</p>
                        <p class="font-medium text-gray-900">{{ $expense->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Bouton retour -->
    <div class="flex justify-center">
        <a href="{{ route('expenses.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>
</div>
@endsection
