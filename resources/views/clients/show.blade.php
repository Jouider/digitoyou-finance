@extends('layouts.app')

@section('title', 'Détails Client')
@section('page-title', $client->name)

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-start mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Informations du Client</h3>
            <div class="space-x-2">
                <a href="{{ route('clients.edit', $client) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <a href="{{ route('clients.index') }}" class="px-4 py-2 border rounded-lg hover:bg-gray-50 transition">
                    Retour
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-medium">{{ $client->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Téléphone</p>
                <p class="font-medium">{{ $client->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Société</p>
                <p class="font-medium">{{ $client->company ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Statut</p>
                <p class="font-medium">
                    @if($client->is_active)
                        <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Actif</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">Inactif</span>
                    @endif
                </p>
            </div>
            <div class="col-span-2">
                <p class="text-sm text-gray-500">Adresse</p>
                <p class="font-medium">{{ $client->address ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Projets du Client</h3>
        @if($client->projects->count() > 0)
            <div class="space-y-3">
                @foreach($client->projects as $project)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-semibold text-lg">{{ $project->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $project->description }}</p>
                                <div class="mt-2 space-x-2">
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ ucfirst($project->status) }}</span>
                                    <span class="text-xs text-gray-500">{{ $project->start_date->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-green-600">{{ number_format($project->price, 2) }} DH</p>
                                <a href="{{ route('projects.show', $project) }}" class="text-sm text-blue-600 hover:underline">Voir détails</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Aucun projet pour ce client</p>
        @endif
    </div>
</div>
@endsection
