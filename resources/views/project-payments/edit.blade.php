@extends('layouts.app')

@section('title', 'Modifier Paiement Client')
@section('page-title', 'Modifier le Paiement Client')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('project-payments.update', $projectPayment) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Projet *</label>
                    <select name="project_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('project_id') border-red-500 @enderror">
                        <option value="">Sélectionner un projet</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ $projectPayment->project_id == $project->id ? 'selected' : '' }}>
                                {{ $project->name }} - {{ $project->client->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de Paiement *</label>
                    <select name="type" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="avance" {{ $projectPayment->type == 'avance' ? 'selected' : '' }}>Avance</option>
                        <option value="partiel" {{ $projectPayment->type == 'partiel' ? 'selected' : '' }}>Paiement Partiel</option>
                        <option value="final" {{ $projectPayment->type == 'final' ? 'selected' : '' }}>Paiement Final</option>
                        <option value="reste" {{ $projectPayment->type == 'reste' ? 'selected' : '' }}>Reste</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant (DH) *</label>
                    <input type="number" name="amount" value="{{ $projectPayment->amount }}" step="0.01" min="0" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('amount') border-red-500 @enderror">
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de Paiement *</label>
                    <input type="date" name="payment_date" value="{{ $projectPayment->payment_date->format('Y-m-d') }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Méthode de Paiement *</label>
                    <select name="payment_method" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="virement" {{ $projectPayment->payment_method == 'virement' ? 'selected' : '' }}>Virement Bancaire</option>
                        <option value="especes" {{ $projectPayment->payment_method == 'especes' ? 'selected' : '' }}>Espèces</option>
                        <option value="cheque" {{ $projectPayment->payment_method == 'cheque' ? 'selected' : '' }}>Chèque</option>
                        <option value="autre" {{ $projectPayment->payment_method == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ $projectPayment->notes }}</textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('project-payments.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
