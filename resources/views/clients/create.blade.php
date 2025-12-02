@extends('layouts.app')

@section('title', 'Nouveau Client')
@section('page-title', 'Ajouter un Client')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Société</label>
                    <input type="text" name="company" value="{{ old('company') }}"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                    <textarea name="address" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('address') }}</textarea>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="mr-2 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label class="text-sm font-medium text-gray-700">Client actif</label>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('clients.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 transition">
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
