@extends('layouts.app')

@section('title', 'Nouvelle Charge')
@section('page-title', 'Ajouter une Charge')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf

            <!-- Nom de la charge -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-2 text-gray-500"></i>Nom de la Charge *
                </label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                    placeholder="Ex: ChatGPT Plus, Adobe Creative Cloud..."
                    value="{{ old('name') }}">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-4">
                    <i class="fas fa-list mr-2 text-gray-500"></i>Type de Charge *
                </label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="abonnement" class="hidden peer" required {{ old('type') === 'abonnement' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center transition peer-checked:border-blue-600 peer-checked:bg-blue-50 hover:border-gray-300">
                            <i class="fas fa-sync-alt text-3xl text-blue-600 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Abonnement</p>
                            <p class="text-xs text-gray-500 mt-1">Services récurrents</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="hebergement" class="hidden peer" {{ old('type') === 'hebergement' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center transition peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:border-gray-300">
                            <i class="fas fa-server text-3xl text-indigo-600 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Hébergement</p>
                            <p class="text-xs text-gray-500 mt-1">Serveurs web</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="domaine" class="hidden peer" {{ old('type') === 'domaine' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center transition peer-checked:border-cyan-600 peer-checked:bg-cyan-50 hover:border-gray-300">
                            <i class="fas fa-globe text-3xl text-cyan-600 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Domaine</p>
                            <p class="text-xs text-gray-500 mt-1">Noms de domaine</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="materiel" class="hidden peer" {{ old('type') === 'materiel' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center transition peer-checked:border-green-600 peer-checked:bg-green-50 hover:border-gray-300">
                            <i class="fas fa-laptop text-3xl text-green-600 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Matériel</p>
                            <p class="text-xs text-gray-500 mt-1">Équipement</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="logiciel" class="hidden peer" {{ old('type') === 'logiciel' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center transition peer-checked:border-purple-600 peer-checked:bg-purple-50 hover:border-gray-300">
                            <i class="fas fa-code text-3xl text-purple-600 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Logiciel</p>
                            <p class="text-xs text-gray-500 mt-1">Software</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="type" value="autre" class="hidden peer" {{ old('type') === 'autre' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center transition peer-checked:border-gray-600 peer-checked:bg-gray-50 hover:border-gray-300">
                            <i class="fas fa-file text-3xl text-gray-600 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Autre</p>
                            <p class="text-xs text-gray-500 mt-1">Divers</p>
                        </div>
                    </label>
                </div>
                @error('type')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fréquence -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-4">
                    <i class="fas fa-calendar-check mr-2 text-gray-500"></i>Fréquence *
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="frequency" value="unique" class="hidden peer" required onchange="toggleNextExpenseDate()" {{ old('frequency') === 'unique' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center transition peer-checked:border-purple-600 peer-checked:bg-purple-50 hover:border-gray-300">
                            <i class="fas fa-shopping-cart text-3xl text-purple-600 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Unique</p>
                            <p class="text-xs text-gray-500 mt-1">Une seule fois</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="frequency" value="mensuel" class="hidden peer" onchange="toggleNextExpenseDate()" {{ old('frequency') === 'mensuel' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center transition peer-checked:border-red-600 peer-checked:bg-red-50 hover:border-gray-300">
                            <i class="fas fa-calendar text-3xl text-red-600 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Mensuel</p>
                            <p class="text-xs text-gray-500 mt-1">Chaque mois</p>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="frequency" value="annuel" class="hidden peer" onchange="toggleNextExpenseDate()" {{ old('frequency') === 'annuel' ? 'checked' : '' }}>
                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center transition peer-checked:border-orange-600 peer-checked:bg-orange-50 hover:border-gray-300">
                            <i class="fas fa-calendar-alt text-3xl text-orange-600 mb-2"></i>
                            <p class="text-sm font-medium text-gray-700">Annuel</p>
                            <p class="text-xs text-gray-500 mt-1">Chaque année</p>
                        </div>
                    </label>
                </div>
                @error('frequency')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Montant et Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-money-bill-wave mr-2 text-gray-500"></i>Montant (DH) *
                    </label>
                    <input type="number" name="amount" id="amount" step="0.01" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('amount') border-red-500 @enderror"
                        placeholder="0.00"
                        value="{{ old('amount') }}">
                    @error('amount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="expense_date" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2 text-gray-500"></i>Date de la Charge *
                    </label>
                    <input type="date" name="expense_date" id="expense_date" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('expense_date') border-red-500 @enderror"
                        value="{{ old('expense_date', date('Y-m-d')) }}">
                    @error('expense_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Prochain Paiement (masqué pour charges uniques) -->
            <div class="mb-6" id="next_expense_date_container" style="display: none;">
                <label for="next_expense_date" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-clock mr-2 text-gray-500"></i>Prochain Paiement
                </label>
                <input type="date" name="next_expense_date" id="next_expense_date"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('next_expense_date') border-red-500 @enderror"
                    value="{{ old('next_expense_date') }}">
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Date du prochain renouvellement pour les charges récurrentes
                </p>
                @error('next_expense_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-align-left mr-2 text-gray-500"></i>Description
                </label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                    placeholder="Détails supplémentaires sur cette charge...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Statut -->
            <div class="mb-8">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="status" value="actif" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        {{ old('status', 'actif') === 'actif' ? 'checked' : '' }}>
                    <span class="ml-3 text-sm font-medium text-gray-700">
                        <i class="fas fa-check-circle mr-2 text-green-600"></i>Charge Active
                    </span>
                </label>
                <p class="ml-8 mt-1 text-sm text-gray-500">Décochez si cette charge n'est plus en cours</p>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('expenses.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>Annuler
                </a>
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-save mr-2"></i>Enregistrer la Charge
                </button>
            </div>
        </form>
    </div>

    <!-- Aide -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-lightbulb text-blue-600 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">💡 Conseils</h3>
                <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                    <li><strong>Charges Uniques</strong> : Achats ponctuels (ordinateur, licence perpétuelle)</li>
                    <li><strong>Charges Mensuelles</strong> : Abonnements renouvelés chaque mois (ChatGPT, Figma)</li>
                    <li><strong>Charges Annuelles</strong> : Services facturés une fois par an (domaines, certificats)</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleNextExpenseDate() {
    const frequency = document.querySelector('input[name="frequency"]:checked');
    const container = document.getElementById('next_expense_date_container');
    const input = document.getElementById('next_expense_date');
    
    if (frequency && frequency.value !== 'unique') {
        container.style.display = 'block';
        input.required = true;
    } else {
        container.style.display = 'none';
        input.required = false;
        input.value = '';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleNextExpenseDate();
});
</script>
@endpush
@endsection
