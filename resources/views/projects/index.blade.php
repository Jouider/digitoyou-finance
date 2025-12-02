@extends('layouts.app')

@section('title', 'Projets')
@section('page-title', 'Gestion des Projets')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold text-gray-800">Liste des Projets</h3>
        <a href="{{ route('projects.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouveau Projet
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paiements</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Début</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($projects as $project)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $project->name }}</div>
                            @if($project->url)
                                <a href="{{ $project->url }}" target="_blank" class="text-xs text-blue-600 hover:underline">
                                    <i class="fas fa-external-link-alt mr-1"></i>{{ $project->url }}
                                </a>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $project->client->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                            {{ number_format($project->price, 2) }} DH
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-gray-600">Payé:</span>
                                    <span class="font-bold text-green-600">{{ number_format($project->total_paid, 2) }} DH</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ min($project->payment_percentage, 100) }}%"></div>
                                </div>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-red-600">Reste:</span>
                                    <span class="font-bold text-red-600">{{ number_format($project->remaining_amount, 2) }} DH</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($project->status === 'en_cours')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">En cours</span>
                            @elseif($project->status === 'termine')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Terminé</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">Maintenance</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $project->start_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('projects.edit', $project) }}" class="text-green-600 hover:text-green-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');">
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
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Aucun projet enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
