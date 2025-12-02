@extends('layouts.app')

@section('title', 'Détails Paiement Client')
@section('page-title', 'Détails du Paiement Client')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-2xl font-semibold text-gray-800">
                    @if($projectPayment->type === 'avance') Avance
                    @elseif($projectPayment->type === 'partiel') Paiement Partiel
                    @elseif($projectPayment->type === 'final') Paiement Final
                    @else Reste
                    @endif
                </h3>
                <p class="text-gray-600 mt-1">{{ $projectPayment->payment_date->format('d/m/Y') }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('project-payments.edit', $projectPayment) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <a href="{{ route('project-payments.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>

        <!-- Montant Principal -->
        <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-6 mb-6">
            <p class="text-sm text-gray-600 mb-2">Montant Payé</p>
            <p class="text-5xl font-bold text-green-600">{{ number_format($projectPayment->amount, 2) }} <span class="text-2xl">DH</span></p>
        </div>

        <!-- Informations du Projet -->
        <div class="mb-6">
            <h4 class="text-lg font-semibold text-gray-800 mb-3">📁 Projet</h4>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="font-medium text-lg">{{ $projectPayment->project->name }}</p>
                <p class="text-gray-600">Client: {{ $projectPayment->project->client->name }}</p>
                <p class="text-sm text-gray-500 mt-2">Prix total du projet: {{ number_format($projectPayment->project->price, 2) }} DH</p>
                <div class="mt-3">
                    <a href="{{ route('projects.show', $projectPayment->project) }}" class="text-blue-600 hover:underline text-sm">
                        <i class="fas fa-external-link-alt mr-1"></i>Voir le projet complet
                    </a>
                </div>
            </div>
        </div>

        <!-- Détails du Paiement -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <h4 class="text-lg font-semibold text-gray-800 mb-3">💳 Détails du Paiement</h4>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Type</span>
                        <span class="font-medium">
                            @if($projectPayment->type === 'avance') Avance
                            @elseif($projectPayment->type === 'partiel') Paiement Partiel
                            @elseif($projectPayment->type === 'final') Paiement Final
                            @else Reste
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Méthode</span>
                        <span class="font-medium capitalize">{{ $projectPayment->payment_method }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Date</span>
                        <span class="font-medium">{{ $projectPayment->payment_date->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-semibold text-gray-800 mb-3">📊 Progression</h4>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Total Payé</span>
                        <span class="font-medium text-green-600">{{ number_format($projectPayment->project->total_paid, 2) }} DH</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Reste à Payer</span>
                        <span class="font-medium text-red-600">{{ number_format($projectPayment->project->remaining_amount, 2) }} DH</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Pourcentage</span>
                        <span class="font-medium text-blue-600">{{ number_format($projectPayment->project->payment_percentage, 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($projectPayment->notes)
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-3">📝 Notes</h4>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                    <p class="text-gray-700">{{ $projectPayment->notes }}</p>
                </div>
            </div>
        @endif

        <!-- Informations Système -->
        <div class="pt-6 border-t">
            <div class="flex justify-between text-sm text-gray-500">
                <p>Créé le: {{ $projectPayment->created_at->format('d/m/Y à H:i') }}</p>
                @if($projectPayment->updated_at != $projectPayment->created_at)
                    <p>Modifié le: {{ $projectPayment->updated_at->format('d/m/Y à H:i') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
