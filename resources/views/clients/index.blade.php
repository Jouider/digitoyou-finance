@extends('layouts.app')

@section('title', 'Clients')
@section('page-title', 'Gestion des Clients')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-xl font-semibold text-gray-800">Liste des Clients</h3>
        <a href="{{ route('clients.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouveau Client
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Société</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Projets</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($clients as $client)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $client->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $client->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $client->phone ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $client->company ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $client->projects_count }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($client->is_active)
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Actif</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">Inactif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('clients.edit', $client) }}" class="text-green-600 hover:text-green-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
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
                            Aucun client enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
