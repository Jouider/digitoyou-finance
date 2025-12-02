@extends('layouts.app')

@section('title', 'Paiements Clients')
@section('page-title', 'Paiements Clients')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Gestion des avances et paiements des clients</p>
        </div>
        <a href="{{ route('project-payments.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nouveau Paiement Client
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet / Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($projectPayments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $payment->project->name }}</div>
                                <div class="text-sm text-gray-500">{{ $payment->project->client->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($payment->type === 'avance') bg-blue-100 text-blue-800
                                    @elseif($payment->type === 'partiel') bg-yellow-100 text-yellow-800
                                    @elseif($payment->type === 'final') bg-green-100 text-green-800
                                    @else bg-purple-100 text-purple-800
                                    @endif">
                                    @if($payment->type === 'avance') Avance
                                    @elseif($payment->type === 'partiel') Paiement Partiel
                                    @elseif($payment->type === 'final') Paiement Final
                                    @else Reste
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                {{ number_format($payment->amount, 2) }} DH
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $payment->payment_date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 capitalize">
                                {{ $payment->payment_method }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                <a href="{{ route('project-payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('project-payments.edit', $payment) }}" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('project-payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?');">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <i class="fas fa-money-bill-wave text-4xl mb-4"></i>
                                    <p class="text-lg">Aucun paiement client enregistré</p>
                                    <p class="text-sm mt-2">Commencez par enregistrer une avance ou un paiement</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($projectPayments->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $projectPayments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
