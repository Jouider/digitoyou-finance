@extends('layouts.app')

@section('title', 'Nouveau Paiement Client')
@section('page-title', 'Enregistrer un Paiement Client')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('project-payments.store') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Projet *</label>
                    <select name="project_id" id="project_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('project_id') border-red-500 @enderror">
                        <option value="">Sélectionner un projet</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" 
                                    data-price="{{ $project->price }}"
                                    data-paid="{{ $project->total_paid }}"
                                    data-remaining="{{ $project->remaining_amount }}"
                                    {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->name }} - {{ $project->client->name }} (Prix: {{ number_format($project->price, 2) }} DH)
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="project-info" class="mt-2 p-3 bg-blue-50 rounded hidden">
                        <p class="text-sm"><strong>Prix total:</strong> <span id="total-price">0</span> DH</p>
                        <p class="text-sm"><strong>Déjà payé:</strong> <span id="paid-amount">0</span> DH</p>
                        <p class="text-sm text-blue-600 font-bold"><strong>Reste à payer:</strong> <span id="remaining-amount">0</span> DH</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de Paiement *</label>
                    <select name="type" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="avance" {{ old('type') == 'avance' ? 'selected' : '' }}>Avance (au démarrage)</option>
                        <option value="partiel" {{ old('type') == 'partiel' ? 'selected' : '' }}>Paiement Partiel (en cours)</option>
                        <option value="final" {{ old('type') == 'final' ? 'selected' : '' }}>Paiement Final (à la livraison)</option>
                        <option value="reste" {{ old('type') == 'reste' ? 'selected' : '' }}>Reste (après livraison)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant (DH) *</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 @error('amount') border-red-500 @enderror">
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de Paiement *</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Méthode de Paiement *</label>
                    <select name="payment_method" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="virement" {{ old('payment_method') == 'virement' ? 'selected' : '' }}>Virement Bancaire</option>
                        <option value="especes" {{ old('payment_method') == 'especes' ? 'selected' : '' }}>Espèces</option>
                        <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Chèque</option>
                        <option value="autre" {{ old('payment_method') == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Remarques ou détails supplémentaires...">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('project-payments.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('project_id').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const infoDiv = document.getElementById('project-info');
    
    if (this.value) {
        const price = selected.dataset.price;
        const paid = selected.dataset.paid;
        const remaining = selected.dataset.remaining;
        
        document.getElementById('total-price').textContent = parseFloat(price).toFixed(2);
        document.getElementById('paid-amount').textContent = parseFloat(paid).toFixed(2);
        document.getElementById('remaining-amount').textContent = parseFloat(remaining).toFixed(2);
        
        infoDiv.classList.remove('hidden');
    } else {
        infoDiv.classList.add('hidden');
    }
});
</script>
@endpush
