@extends('layouts.app')

@section('title', 'Détails du Projet')
@section('page-title', $project->name)

@section('content')
<div class="space-y-6">
    <!-- Informations du Projet -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Informations du Projet</h3>
                <p class="text-gray-600">Client: <span class="font-medium">{{ $project->client->name }}</span></p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-600 mb-1">Description</p>
                <p class="font-medium">{{ $project->description ?? 'Aucune description' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">URL</p>
                @if($project->url)
                    <a href="{{ $project->url }}" target="_blank" class="font-medium text-blue-600 hover:underline">
                        {{ $project->url }} <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                @else
                    <p class="font-medium text-gray-400">Non définie</p>
                @endif
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">Prix Total</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($project->price, 2) }} DH</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">Statut</p>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($project->status === 'en_cours') bg-blue-100 text-blue-800
                    @elseif($project->status === 'termine') bg-green-100 text-green-800
                    @else bg-purple-100 text-purple-800
                    @endif">
                    @if($project->status === 'en_cours') En cours
                    @elseif($project->status === 'termine') Terminé
                    @else Maintenance
                    @endif
                </span>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">Date de Début</p>
                <p class="font-medium">{{ $project->start_date->format('d/m/Y') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600 mb-1">Date de Fin</p>
                <p class="font-medium">{{ $project->end_date ? $project->end_date->format('d/m/Y') : 'En cours' }}</p>
            </div>
        </div>
    </div>

    <!-- Suivi des Paiements Clients -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">💰 Suivi des Paiements Clients</h3>
            <a href="{{ route('project-payments.create') }}?project_id={{ $project->id }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i>Ajouter Paiement
            </a>
        </div>

        <!-- Barre de progression -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-700">Progression des Paiements</span>
                <span class="text-sm font-bold text-blue-600">{{ number_format($project->payment_percentage, 1) }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-gradient-to-r from-blue-500 to-green-500 h-4 rounded-full transition-all duration-500" 
                     style="width: {{ min($project->payment_percentage, 100) }}%"></div>
            </div>
            <div class="flex justify-between items-center mt-2 text-sm">
                <span class="text-gray-600">Payé: <strong>{{ number_format($project->total_paid, 2) }} DH</strong></span>
                <span class="text-red-600">Reste: <strong>{{ number_format($project->remaining_amount, 2) }} DH</strong></span>
            </div>
        </div>

        <!-- Liste des paiements -->
        @if($project->projectPayments->count() > 0)
            <div class="space-y-3">
                @foreach($project->projectPayments->sortByDesc('payment_date') as $payment)
                    <div class="flex items-center justify-between p-4 border rounded-lg hover:shadow-md transition">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center
                                @if($payment->type === 'avance') bg-blue-100
                                @elseif($payment->type === 'partiel') bg-yellow-100
                                @elseif($payment->type === 'final') bg-green-100
                                @else bg-purple-100
                                @endif">
                                <i class="fas fa-money-bill-wave text-lg
                                    @if($payment->type === 'avance') text-blue-600
                                    @elseif($payment->type === 'partiel') text-yellow-600
                                    @elseif($payment->type === 'final') text-green-600
                                    @else text-purple-600
                                    @endif"></i>
                            </div>
                            <div>
                                <p class="font-semibold">
                                    @if($payment->type === 'avance') Avance
                                    @elseif($payment->type === 'partiel') Paiement Partiel
                                    @elseif($payment->type === 'final') Paiement Final
                                    @else Reste
                                    @endif
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $payment->payment_date->format('d/m/Y') }} - 
                                    <span class="capitalize">{{ $payment->payment_method }}</span>
                                </p>
                                @if($payment->notes)
                                    <p class="text-xs text-gray-500 mt-1">{{ $payment->notes }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-gray-900">{{ number_format($payment->amount, 2) }} DH</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-400">
                <i class="fas fa-money-bill-wave text-4xl mb-4"></i>
                <p>Aucun paiement enregistré pour ce projet</p>
                <p class="text-sm mt-2">Commencez par enregistrer une avance</p>
            </div>
        @endif
    </div>

    <!-- Paiements Récurrents (Hébergement/Domaines) -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">🖥️ Hébergements & Domaines</h3>
        @if($project->payments->count() > 0)
            <div class="space-y-3">
                @foreach($project->payments as $payment)
                    <div class="flex items-center justify-between p-4 border-l-4 
                        @if($payment->type === 'hebergement') border-blue-500 bg-blue-50
                        @elseif($payment->type === 'domaine') border-green-500 bg-green-50
                        @else border-gray-500 bg-gray-50
                        @endif rounded">
                        <div>
                            <p class="font-semibold">{{ $payment->description }}</p>
                            <p class="text-sm text-gray-600">
                                Type: <span class="capitalize">{{ $payment->type }}</span> | 
                                Fréquence: {{ $payment->frequency }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Prochain paiement: {{ $payment->next_payment_date ? $payment->next_payment_date->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-lg font-bold">{{ number_format($payment->amount, 2) }} DH</p>
                            <span class="text-xs px-2 py-1 rounded
                                @if($payment->status === 'paye') bg-green-100 text-green-800
                                @elseif($payment->status === 'en_attente') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-400 py-4">Aucun paiement récurrent enregistré</p>
        @endif
    </div>

    <!-- Distributions de Bénéfices -->
    @if($project->profitDistributions->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">📊 Distributions de Bénéfices</h3>
            <div class="space-y-3">
                @foreach($project->profitDistributions as $distribution)
                    <div class="p-4 border rounded-lg">
                        <div class="flex justify-between items-center mb-3">
                            <p class="font-semibold">Distribution du {{ $distribution->distribution_date->format('d/m/Y') }}</p>
                            <p class="text-xl font-bold text-green-600">{{ number_format($distribution->total_profit, 2) }} DH</p>
                        </div>
                        <div class="grid grid-cols-4 gap-4 text-sm">
                            <div class="text-center p-2 bg-blue-50 rounded">
                                <p class="text-gray-600">Abdellah</p>
                                <p class="font-bold text-blue-600">{{ number_format($distribution->abdellah_share, 2) }} DH</p>
                            </div>
                            <div class="text-center p-2 bg-green-50 rounded">
                                <p class="text-gray-600">Mouad</p>
                                <p class="font-bold text-green-600">{{ number_format($distribution->mouad_share, 2) }} DH</p>
                            </div>
                            <div class="text-center p-2 bg-purple-50 rounded">
                                <p class="text-gray-600">Agence</p>
                                <p class="font-bold text-purple-600">{{ number_format($distribution->agency_share, 2) }} DH</p>
                            </div>
                            <div class="text-center p-2 bg-yellow-50 rounded">
                                <p class="text-gray-600">Sadaqah</p>
                                <p class="font-bold text-yellow-600">{{ number_format($distribution->sadaqah_share, 2) }} DH</p>
                            </div>
                        </div>
                        @if($distribution->notes)
                            <p class="text-sm text-gray-600 mt-3">{{ $distribution->notes }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
