@extends('layouts.app')

@section('title', 'Rapport Annuel')
@section('page-title', 'Rapport Annuel')

@section('content')
<div class="space-y-6">
    <!-- Sélecteur d'année -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Rapport Financier {{ $year }}</h2>
                <p class="text-gray-600 mt-1">Vue d'ensemble mensuelle des revenus et dépenses</p>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('annual-report', ['year' => $year - 1]) }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-chevron-left mr-2"></i>{{ $year - 1 }}
                </a>
                <span class="text-2xl font-bold text-blue-600">{{ $year }}</span>
                <a href="{{ route('annual-report', ['year' => $year + 1]) }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    {{ $year + 1 }}<i class="fas fa-chevron-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistiques annuelles -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Revenus Totaux</p>
                    <p class="text-3xl font-bold">{{ number_format($totalRevenue, 0) }} DH</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-arrow-up text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm mb-1">Charges Totales</p>
                    <p class="text-3xl font-bold">{{ number_format($totalExpenses, 0) }} DH</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-arrow-down text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Bénéfice Net</p>
                    <p class="text-3xl font-bold">{{ number_format($netProfit, 0) }} DH</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-coins text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Projets Terminés</p>
                    <p class="text-3xl font-bold">{{ $completedProjects }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau mensuel -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">
                <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>Résultats Mensuels
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mois</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Projets</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Paiements</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Charges</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Bénéfice Net</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Abdellah</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Mouad</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Agence</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Sadaqah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($monthlyData as $month => $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::create($year, $month, 1)->locale('fr')->translatedFormat('F') }}
                                </div>
                                <div class="text-xs text-gray-500">{{ $year }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="px-2 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full">
                                    {{ $data['projects_count'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-bold text-green-600">
                                    {{ number_format($data['payments_received'], 2) }} DH
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-bold text-red-600">
                                    {{ number_format($data['expenses'], 2) }} DH
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-bold {{ $data['profit'] >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                    {{ number_format($data['profit'], 2) }} DH
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-blue-700">
                                    {{ number_format($data['abdellah_share'], 2) }} DH
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-green-700">
                                    {{ number_format($data['mouad_share'], 2) }} DH
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-purple-700">
                                    {{ number_format($data['agency_share'], 2) }} DH
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-medium text-yellow-700">
                                    {{ number_format($data['sadaqah_share'], 2) }} DH
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    
                    <!-- Total -->
                    <tr class="bg-gray-100 font-bold">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            TOTAL {{ $year }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <span class="px-2 py-1 text-xs font-semibold bg-purple-200 text-purple-900 rounded-full">
                                {{ $completedProjects }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-green-700">
                            {{ number_format($totalRevenue, 2) }} DH
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-red-700">
                            {{ number_format($totalExpenses, 2) }} DH
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm {{ $netProfit >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                            {{ number_format($netProfit, 2) }} DH
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-blue-900">
                            {{ number_format($yearlyShares['abdellah'], 2) }} DH
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-green-900">
                            {{ number_format($yearlyShares['mouad'], 2) }} DH
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-purple-900">
                            {{ number_format($yearlyShares['agency'], 2) }} DH
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-yellow-900">
                            {{ number_format($yearlyShares['sadaqah'], 2) }} DH
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Meilleurs mois -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-trophy mr-2 text-yellow-500"></i>Meilleurs Mois
            </h3>
            <div class="space-y-3">
                @php
                    $topMonths = collect($monthlyData)->sortByDesc('profit')->take(3);
                @endphp
                @foreach($topMonths as $month => $data)
                    <div class="flex items-center justify-between p-3 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">
                                {{ $loop->iteration }}
                            </div>
                            <span class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::create($year, $month, 1)->locale('fr')->translatedFormat('F') }}
                            </span>
                        </div>
                        <span class="font-bold text-green-600">
                            {{ number_format($data['profit'], 2) }} DH
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Répartition des revenus -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                <i class="fas fa-chart-pie mr-2 text-blue-500"></i>Répartition Annuelle
            </h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-700">Paiements Clients</span>
                        <span class="font-bold text-green-600">{{ number_format($totalRevenue, 2) }} DH</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" style="width: {{ $totalRevenue > 0 ? 100 : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-700">Charges Totales</span>
                        <span class="font-bold text-red-600">{{ number_format($totalExpenses, 2) }} DH</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-red-500 h-3 rounded-full" style="width: {{ $totalRevenue > 0 ? ($totalExpenses / $totalRevenue * 100) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-700">Bénéfice Net</span>
                        <span class="font-bold text-blue-600">{{ number_format($netProfit, 2) }} DH</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $totalRevenue > 0 ? ($netProfit / $totalRevenue * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Distributions totales -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">💰 Distributions de l'année {{ $year }}</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <p class="text-indigo-100 text-sm mb-1">Abdellah</p>
                <p class="text-2xl font-bold">{{ number_format($yearlyShares['abdellah'], 2) }} DH</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <p class="text-indigo-100 text-sm mb-1">Mouad</p>
                <p class="text-2xl font-bold">{{ number_format($yearlyShares['mouad'], 2) }} DH</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <p class="text-indigo-100 text-sm mb-1">Agence</p>
                <p class="text-2xl font-bold">{{ number_format($yearlyShares['agency'], 2) }} DH</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <p class="text-indigo-100 text-sm mb-1">🤲 Sadaqah</p>
                <p class="text-2xl font-bold">{{ number_format($yearlyShares['sadaqah'], 2) }} DH</p>
            </div>
        </div>
    </div>
</div>
@endsection
