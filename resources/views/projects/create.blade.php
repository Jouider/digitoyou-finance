@extends('layouts.app')

@section('title', 'Nouveau Projet')
@section('page-title', 'Créer un Projet')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Client *</label>
                    <select name="client_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('client_id') border-red-500 @enderror">
                        <option value="">Sélectionner un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} @if($client->company) - {{ $client->company }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom du Projet *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL du Site</label>
                    <input type="url" name="url" value="{{ old('url') }}"
                           placeholder="https://exemple.ma"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix (DH) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                    <select name="status" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="en_cours" {{ old('status') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="termine" {{ old('status') == 'termine' ? 'selected' : '' }}>Terminé</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de Début *</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de Fin</label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('projects.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
