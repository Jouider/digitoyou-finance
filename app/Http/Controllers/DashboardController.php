<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Expense;
use App\Models\ProfitDistribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_clients' => Client::where('is_active', true)->count(),
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', 'en_cours')->count(),
            'total_revenue' => Project::sum('price'),
        ];

        // Charges mensuelles
        $monthlyExpenses = Expense::where('status', 'actif')
            ->whereIn('frequency', ['mensuel', 'annuel'])
            ->get();

        // Calcul des dépenses du mois
        $totalMonthlyExpenses = $monthlyExpenses->sum(function($expense) {
            if ($expense->frequency === 'mensuel') {
                return $expense->amount;
            } else if ($expense->frequency === 'annuel') {
                return $expense->amount / 12;
            }
            return 0;
        });

        // Charges à venir ce mois (renouvellements)
        $upcomingExpenses = Expense::where('status', 'actif')
            ->whereNotNull('next_expense_date')
            ->whereMonth('next_expense_date', now()->month)
            ->whereYear('next_expense_date', now()->year)
            ->orderBy('next_expense_date')
            ->get();

        // Dernières distributions
        $recentDistributions = ProfitDistribution::with('project.client')
            ->orderBy('distribution_date', 'desc')
            ->take(5)
            ->get();

        // Total Sadaqah
        $totalSadaqah = ProfitDistribution::sum('sadaqah_share');

        // Parts totales
        $totalShares = [
            'abdellah' => ProfitDistribution::sum('abdellah_share'),
            'mouad' => ProfitDistribution::sum('mouad_share'),
            'agency' => ProfitDistribution::sum('agency_share'),
            'sadaqah' => $totalSadaqah,
        ];

        return view('dashboard', compact(
            'stats',
            'monthlyExpenses',
            'totalMonthlyExpenses',
            'upcomingExpenses',
            'recentDistributions',
            'totalShares'
        ));
    }
}
