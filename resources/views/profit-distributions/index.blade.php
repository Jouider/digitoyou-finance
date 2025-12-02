@extends('layouts.app')

@section('title', 'Répartition des Bénéfices')
@section('page-title', 'Répartition des Bénéfices')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Distribution des profits : 10% Agence, 10% Sadaqah, reste 50-50</p>
        </div>
        <a href="{{ route('profit-distributions.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nouvelle Distribution
        </a>
    </div>

    <!-- Statistiques globales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Part Abdellah</p>
                    <p class="text-3xl font-bold">
                        {{ number_format($distributions->sum('abdellah_share'), 2) }} DH
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-user text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm mb-1">Part Mouad</p>
                    <p class="text-3xl font-bold">
                        {{ number_format($distributions->sum('mouad_share'), 2) }} DH
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-user text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Part Agence (10%)</p>
                    <p class="text-3xl font-bold">
                        {{ number_format($distributions->sum('agency_share'), 2) }} DH
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-briefcase text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-100 text-sm mb-1">🤲 Sadaqah (10%)</p>
                    <p class="text-3xl font-bold">
                        {{ number_format($distributions->sum('sadaqah_share'), 2) }} DH
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-hand-holding-heart text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Bénéfice total -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-semibold mb-2">💰 Bénéfice Total Distribué</h3>
                <p class="text-4xl font-bold">
                    {{ number_format($distributions->sum('total_profit'), 2) }} DH
                </p>
                <p class="text-indigo-100 mt-2">Sur {{ $distributions->count() }} distribution(s)</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-4">
                <i class="fas fa-coins text-4xl"></i>
            </div>
        </div>
    </div>

    <!-- Liste des distributions -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bénéfice</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abdellah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mouad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agence</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sadaqah</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($distributions as $distribution)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $distribution->project->name }}</div>
                                <div class="text-xs text-gray-500">{{ $distribution->project->client->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $distribution->distribution_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                {{ number_format($distribution->total_profit, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">
                                {{ number_format($distribution->abdellah_share, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                {{ number_format($distribution->mouad_share, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600">
                                {{ number_format($distribution->agency_share, 2) }} DH
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-yellow-600">
                                {{ number_format($distribution->sadaqah_share, 2) }} DH
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2 whitespace-nowrap">
                                <a href="{{ route('profit-distributions.show', $distribution) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('profit-distributions.edit', $distribution) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('profit-distributions.destroy', $distribution) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette distribution ?');">
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
                                    <i class="fas fa-hand-holding-usd text-4xl mb-4"></i>
                                    <p class="text-lg">Aucune distribution enregistrée</p>
                                    <p class="text-sm mt-2">Commencez par créer une distribution de bénéfices</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Graphique de répartition -->
    @if($distributions->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">
                <i class="fas fa-chart-pie mr-2 text-gray-500"></i>Répartition Globale
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $totalAbdellah = $distributions->sum('abdellah_share');
                    $totalMouad = $distributions->sum('mouad_share');
                    $totalAgency = $distributions->sum('agency_share');
                    $totalSadaqah = $distributions->sum('sadaqah_share');
                    $grandTotal = $totalAbdellah + $totalMouad + $totalAgency + $totalSadaqah;
                @endphp
                
                <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                    <p class="text-sm text-blue-800 mb-1">Abdellah</p>
                    <p class="text-2xl font-bold text-blue-600">
                        {{ $grandTotal > 0 ? number_format(($totalAbdellah / $grandTotal) * 100, 1) : 0 }}%
                    </p>
                    <p class="text-xs text-blue-600 mt-1">{{ number_format($totalAbdellah, 2) }} DH</p>
                </div>

                <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                    <p class="text-sm text-green-800 mb-1">Mouad</p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ $grandTotal > 0 ? number_format(($totalMouad / $grandTotal) * 100, 1) : 0 }}%
                    </p>
                    <p class="text-xs text-green-600 mt-1">{{ number_format($totalMouad, 2) }} DH</p>
                </div>

                <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-500">
                    <p class="text-sm text-purple-800 mb-1">Agence</p>
                    <p class="text-2xl font-bold text-purple-600">
                        {{ $grandTotal > 0 ? number_format(($totalAgency / $grandTotal) * 100, 1) : 0 }}%
                    </p>
                    <p class="text-xs text-purple-600 mt-1">{{ number_format($totalAgency, 2) }} DH</p>
                </div>

                <div class="bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-500">
                    <p class="text-sm text-yellow-800 mb-1">🤲 Sadaqah</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        {{ $grandTotal > 0 ? number_format(($totalSadaqah / $grandTotal) * 100, 1) : 0 }}%
                    </p>
                    <p class="text-xs text-yellow-600 mt-1">{{ number_format($totalSadaqah, 2) }} DH</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
