@extends('layouts.app')

@section('title', 'Nouvelle Distribution')
@section('page-title', 'Nouvelle Distribution de Bénéfices')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('profit-distributions.store') }}" method="POST" id="distributionForm">
            @csrf

            <!-- Sélection du projet -->
            <div class="mb-6">
                <label for="project_id" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-folder mr-2 text-gray-500"></i>Projet *
                </label>
                <select name="project_id" id="project_id" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('project_id') border-red-500 @enderror">
                    <option value="">Sélectionnez un projet</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" 
                            data-price="{{ $project->price }}"
                            {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }} - {{ $project->client->name }} ({{ number_format($project->price, 2) }} DH)
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bénéfice total -->
            <div class="mb-6">
                <label for="total_profit" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-coins mr-2 text-gray-500"></i>Bénéfice Total (DH) *
                </label>
                <input type="number" name="total_profit" id="total_profit" step="0.01" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('total_profit') border-red-500 @enderror"
                    placeholder="Ex: Prix projet - Coûts"
                    value="{{ old('total_profit') }}"
                    oninput="calculateShares()">
                @error('total_profit')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Le bénéfice = Prix du projet - Coûts (hébergement, domaine, etc.)
                </p>
            </div>

            <!-- Pourcentages -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="agency_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-briefcase mr-2 text-gray-500"></i>Pourcentage Agence (%) *
                    </label>
                    <input type="number" name="agency_percentage" id="agency_percentage" step="0.01" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('agency_percentage') border-red-500 @enderror"
                        value="{{ old('agency_percentage', '10') }}"
                        oninput="calculateShares()">
                    @error('agency_percentage')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sadaqah_percentage" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-hand-holding-heart mr-2 text-gray-500"></i>Pourcentage Sadaqah (%) *
                    </label>
                    <input type="number" name="sadaqah_percentage" id="sadaqah_percentage" step="0.01" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sadaqah_percentage') border-red-500 @enderror"
                        value="{{ old('sadaqah_percentage', '10') }}"
                        oninput="calculateShares()">
                    @error('sadaqah_percentage')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Aperçu des calculs -->
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 mb-6" id="calculationPreview">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">
                    <i class="fas fa-calculator mr-2"></i>Aperçu de la Répartition
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-xs text-gray-600 mb-1">Abdellah (50%)</p>
                        <p class="text-xl font-bold text-blue-600" id="abdellah_preview">0.00 DH</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-xs text-gray-600 mb-1">Mouad (50%)</p>
                        <p class="text-xl font-bold text-green-600" id="mouad_preview">0.00 DH</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-xs text-gray-600 mb-1">Agence</p>
                        <p class="text-xl font-bold text-purple-600" id="agency_preview">0.00 DH</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm">
                        <p class="text-xs text-gray-600 mb-1">🤲 Sadaqah</p>
                        <p class="text-xl font-bold text-yellow-600" id="sadaqah_preview">0.00 DH</p>
                    </div>
                </div>
            </div>

            <!-- Date de distribution -->
            <div class="mb-6">
                <label for="distribution_date" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-calendar mr-2 text-gray-500"></i>Date de Distribution *
                </label>
                <input type="date" name="distribution_date" id="distribution_date" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('distribution_date') border-red-500 @enderror"
                    value="{{ old('distribution_date', date('Y-m-d')) }}">
                @error('distribution_date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="mb-8">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-2 text-gray-500"></i>Notes
                </label>
                <textarea name="notes" id="notes" rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                    placeholder="Notes supplémentaires sur cette distribution...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('profit-distributions.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>Annuler
                </a>
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-save mr-2"></i>Enregistrer la Distribution
                </button>
            </div>
        </form>
    </div>

    <!-- Aide -->
    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">ℹ️ Règles de Distribution</h3>
                <ul class="mt-2 text-sm text-blue-700 list-disc list-inside space-y-1">
                    <li><strong>10% Agence</strong> : Part réservée pour les dépenses et investissements</li>
                    <li><strong>10% Sadaqah</strong> : Part charitable (selon les principes islamiques)</li>
                    <li><strong>Reste 50-50</strong> : Le montant restant est divisé équitablement entre Abdellah et Mouad</li>
                    <li>Les pourcentages peuvent être ajustés selon les besoins du projet</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function calculateShares() {
    const totalProfit = parseFloat(document.getElementById('total_profit').value) || 0;
    const agencyPercentage = parseFloat(document.getElementById('agency_percentage').value) || 0;
    const sadaqahPercentage = parseFloat(document.getElementById('sadaqah_percentage').value) || 0;
    
    // Calcul des parts
    const agencyShare = (totalProfit * agencyPercentage) / 100;
    const sadaqahShare = (totalProfit * sadaqahPercentage) / 100;
    const remaining = totalProfit - agencyShare - sadaqahShare;
    const abdellahShare = remaining / 2;
    const mouadShare = remaining / 2;
    
    // Mise à jour de l'aperçu
    document.getElementById('abdellah_preview').textContent = abdellahShare.toFixed(2) + ' DH';
    document.getElementById('mouad_preview').textContent = mouadShare.toFixed(2) + ' DH';
    document.getElementById('agency_preview').textContent = agencyShare.toFixed(2) + ' DH';
    document.getElementById('sadaqah_preview').textContent = sadaqahShare.toFixed(2) + ' DH';
}

// Calculer au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    calculateShares();
});
</script>
@endpush
@endsection
