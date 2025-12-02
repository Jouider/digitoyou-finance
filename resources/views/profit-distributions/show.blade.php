@extends('layouts.app')

@section('title', 'Détails de la Distribution')
@section('page-title', 'Détails de la Distribution')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- En-tête avec actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $profitDistribution->project->name }}</h2>
                <p class="text-gray-600">Client: {{ $profitDistribution->project->client->name }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fas fa-calendar mr-1"></i>
                    Distribution effectuée le {{ $profitDistribution->distribution_date->format('d/m/Y') }}
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('profit-distributions.edit', $profitDistribution) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <form action="{{ route('profit-distributions.destroy', $profitDistribution) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette distribution ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bénéfice total -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow-md p-8">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-semibold text-indigo-100 mb-2">💰 Bénéfice Total</h3>
                <p class="text-5xl font-bold mb-2">{{ number_format($profitDistribution->total_profit, 2) }} DH</p>
                <p class="text-indigo-100">
                    Prix projet: {{ number_format($profitDistribution->project->price, 2) }} DH
                </p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-6">
                <i class="fas fa-chart-pie text-5xl"></i>
            </div>
        </div>
    </div>

    <!-- Répartition des parts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Abdellah -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-blue-100">Part Abdellah</h3>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-user text-2xl"></i>
                </div>
            </div>
            <p class="text-4xl font-bold mb-2">{{ number_format($profitDistribution->abdellah_share, 2) }} DH</p>
            <p class="text-blue-100">
                50% du montant après déductions
            </p>
        </div>

        <!-- Mouad -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-green-100">Part Mouad</h3>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-user text-2xl"></i>
                </div>
            </div>
            <p class="text-4xl font-bold mb-2">{{ number_format($profitDistribution->mouad_share, 2) }} DH</p>
            <p class="text-green-100">
                50% du montant après déductions
            </p>
        </div>
    </div>

    <!-- Déductions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Agence -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Part Agence</h3>
                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                    {{ number_format($profitDistribution->agency_percentage, 1) }}%
                </span>
            </div>
            <p class="text-3xl font-bold text-purple-600 mb-2">
                {{ number_format($profitDistribution->agency_share, 2) }} DH
            </p>
            <p class="text-sm text-gray-600">
                <i class="fas fa-briefcase mr-1"></i>
                Réservé pour dépenses et investissements
            </p>
        </div>

        <!-- Sadaqah -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">🤲 Sadaqah</h3>
                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                    {{ number_format($profitDistribution->sadaqah_percentage, 1) }}%
                </span>
            </div>
            <p class="text-3xl font-bold text-yellow-600 mb-2">
                {{ number_format($profitDistribution->sadaqah_share, 2) }} DH
            </p>
            <p class="text-sm text-gray-600">
                <i class="fas fa-hand-holding-heart mr-1"></i>
                Part charitable
            </p>
        </div>
    </div>

    <!-- Détails du calcul -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-calculator mr-2 text-gray-500"></i>Détail du Calcul
        </h3>
        <div class="space-y-4">
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                <span class="text-gray-700">Bénéfice total</span>
                <span class="font-bold text-gray-900">{{ number_format($profitDistribution->total_profit, 2) }} DH</span>
            </div>
            <div class="flex justify-between items-center p-3 bg-purple-50 rounded">
                <span class="text-purple-700">- Part Agence ({{ number_format($profitDistribution->agency_percentage, 1) }}%)</span>
                <span class="font-bold text-purple-600">{{ number_format($profitDistribution->agency_share, 2) }} DH</span>
            </div>
            <div class="flex justify-between items-center p-3 bg-yellow-50 rounded">
                <span class="text-yellow-700">- Sadaqah ({{ number_format($profitDistribution->sadaqah_percentage, 1) }}%)</span>
                <span class="font-bold text-yellow-600">{{ number_format($profitDistribution->sadaqah_share, 2) }} DH</span>
            </div>
            <div class="flex justify-between items-center p-3 bg-green-50 rounded border-t-2 border-green-200">
                <span class="text-green-700 font-semibold">= Montant à partager (50-50)</span>
                <span class="font-bold text-green-600">
                    {{ number_format($profitDistribution->total_profit - $profitDistribution->agency_share - $profitDistribution->sadaqah_share, 2) }} DH
                </span>
            </div>
            <div class="grid grid-cols-2 gap-4 pt-2">
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded">
                    <span class="text-blue-700">Part Abdellah</span>
                    <span class="font-bold text-blue-600">{{ number_format($profitDistribution->abdellah_share, 2) }} DH</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-green-50 rounded">
                    <span class="text-green-700">Part Mouad</span>
                    <span class="font-bold text-green-600">{{ number_format($profitDistribution->mouad_share, 2) }} DH</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($profitDistribution->notes)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-3">
                <i class="fas fa-sticky-note mr-2 text-gray-500"></i>Notes
            </h3>
            <p class="text-gray-700 whitespace-pre-line">{{ $profitDistribution->notes }}</p>
        </div>
    @endif

    <!-- Informations du projet -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-info-circle mr-2 text-gray-500"></i>Informations du Projet
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="flex items-center text-gray-600">
                <i class="fas fa-folder w-6 mr-3 text-gray-400"></i>
                <div>
                    <p class="text-gray-500">Nom du projet</p>
                    <p class="font-medium text-gray-900">{{ $profitDistribution->project->name }}</p>
                </div>
            </div>
            <div class="flex items-center text-gray-600">
                <i class="fas fa-user w-6 mr-3 text-gray-400"></i>
                <div>
                    <p class="text-gray-500">Client</p>
                    <p class="font-medium text-gray-900">{{ $profitDistribution->project->client->name }}</p>
                </div>
            </div>
            <div class="flex items-center text-gray-600">
                <i class="fas fa-dollar-sign w-6 mr-3 text-gray-400"></i>
                <div>
                    <p class="text-gray-500">Prix du projet</p>
                    <p class="font-medium text-gray-900">{{ number_format($profitDistribution->project->price, 2) }} DH</p>
                </div>
            </div>
            <div class="flex items-center text-gray-600">
                <i class="fas fa-tag w-6 mr-3 text-gray-400"></i>
                <div>
                    <p class="text-gray-500">Statut du projet</p>
                    <p class="font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $profitDistribution->project->status) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Métadonnées -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            <i class="fas fa-clock mr-2 text-gray-500"></i>Historique
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="flex items-center text-gray-600">
                <i class="fas fa-calendar-plus w-6 mr-3 text-gray-400"></i>
                <div>
                    <p class="text-gray-500">Date de création</p>
                    <p class="font-medium text-gray-900">{{ $profitDistribution->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            @if($profitDistribution->updated_at != $profitDistribution->created_at)
                <div class="flex items-center text-gray-600">
                    <i class="fas fa-edit w-6 mr-3 text-gray-400"></i>
                    <div>
                        <p class="text-gray-500">Dernière modification</p>
                        <p class="font-medium text-gray-900">{{ $profitDistribution->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Bouton retour -->
    <div class="flex justify-center">
        <a href="{{ route('profit-distributions.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>
</div>
@endsection
