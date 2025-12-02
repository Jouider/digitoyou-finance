@extends('layouts.app')

@section('title', 'Dashboard - Finance Agence')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Clients Actifs</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_clients'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Projets Actifs</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['active_projects'] }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-folder-open text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Revenu Total</p>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($stats['total_revenue'], 2) }} DH</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-dollar-sign text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Charges Mensuelles</p>
                    <p class="text-3xl font-bold text-red-600">{{ number_format($totalMonthlyExpenses, 2) }} DH</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <i class="fas fa-receipt text-red-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Répartition des bénéfices -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">💰 Répartition Totale</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-blue-50 rounded">
                    <span class="font-medium">Abdellah</span>
                    <span class="text-blue-600 font-bold">{{ number_format($totalShares['abdellah'], 2) }} DH</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-green-50 rounded">
                    <span class="font-medium">Mouad</span>
                    <span class="text-green-600 font-bold">{{ number_format($totalShares['mouad'], 2) }} DH</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-purple-50 rounded">
                    <span class="font-medium">Agence (10%)</span>
                    <span class="text-purple-600 font-bold">{{ number_format($totalShares['agency'], 2) }} DH</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-yellow-50 rounded">
                    <span class="font-medium">🤲 Sadaqah (10%)</span>
                    <span class="text-yellow-600 font-bold">{{ number_format($totalShares['sadaqah'], 2) }} DH</span>
                </div>
            </div>
        </div>

        <!-- Charges à renouveler ce mois -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">📅 Charges à renouveler (ce mois)</h3>
            <div class="space-y-2 max-h-64 overflow-y-auto">
                @forelse($upcomingExpenses as $expense)
                    <div class="flex justify-between items-center p-3 border-l-4 
                        @if($expense->type === 'abonnement') border-blue-500 bg-blue-50
                        @elseif($expense->type === 'logiciel') border-purple-500 bg-purple-50
                        @elseif($expense->type === 'materiel') border-green-500 bg-green-50
                        @else border-gray-500 bg-gray-50
                        @endif
                        rounded">
                        <div>
                            <p class="font-medium text-sm">{{ $expense->name }}</p>
                            <p class="text-xs text-gray-600 capitalize">{{ $expense->type }} - {{ $expense->frequency }}</p>
                            <p class="text-xs text-gray-500">{{ $expense->next_expense_date->format('d/m/Y') }}</p>
                        </div>
                        <span class="font-bold text-sm">{{ number_format($expense->amount, 2) }} DH</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Aucun renouvellement prévu ce mois</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Dernières distributions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">📊 Dernières Distributions</h3>
            <a href="{{ route('profit-distributions.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Nouvelle Distribution
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bénéfice</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Abdellah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mouad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agence</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sadaqah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentDistributions as $distribution)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $distribution->project->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $distribution->project->client->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $distribution->distribution_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ number_format($distribution->total_profit, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">
                                {{ number_format($distribution->abdellah_share, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                                {{ number_format($distribution->mouad_share, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-600 font-medium">
                                {{ number_format($distribution->agency_share, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-medium">
                                {{ number_format($distribution->sadaqah_share, 2) }} DH
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Aucune distribution enregistrée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Charges actives -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">💳 Charges Récurrentes</h3>
            <a href="{{ route('expenses.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i>Ajouter Charge
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($monthlyExpenses as $expense)
                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium">{{ $expense->name }}</h4>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $expense->frequency }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ $expense->type }}</p>
                    <p class="text-lg font-bold text-gray-900">{{ number_format($expense->amount, 2) }} DH</p>
                    @if($expense->next_expense_date)
                        <p class="text-xs text-gray-500 mt-2">Prochain: {{ $expense->next_expense_date->format('d/m/Y') }}</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 col-span-3 text-center py-4">Aucune charge récurrente</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
