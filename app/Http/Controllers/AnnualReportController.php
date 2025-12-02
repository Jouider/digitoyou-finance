<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectPayment;
use App\Models\Expense;
use App\Models\ProfitDistribution;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnnualReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);
        
        // Initialiser les données mensuelles
        $monthlyData = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthlyData[$month] = [
                'projects_count' => 0,
                'payments_received' => 0,
                'expenses' => 0,
                'profit' => 0,
                'distributions' => 0,
                'abdellah_share' => 0,
                'mouad_share' => 0,
                'agency_share' => 0,
                'sadaqah_share' => 0,
            ];
        }
        
        // Paiements clients reçus par mois
        $payments = ProjectPayment::whereYear('payment_date', $year)->get();
        foreach ($payments as $payment) {
            $month = $payment->payment_date->month;
            $monthlyData[$month]['payments_received'] += $payment->amount;
        }
        
        // Charges par mois
        $expenses = Expense::where('status', 'actif')
            ->whereYear('expense_date', '<=', $year)
            ->get();
        
        foreach ($expenses as $expense) {
            // Déterminer les mois concernés
            if ($expense->frequency === 'unique') {
                // Charge unique : compter seulement le mois de la dépense
                if ($expense->expense_date->year == $year) {
                    $month = $expense->expense_date->month;
                    $monthlyData[$month]['expenses'] += $expense->amount;
                }
            } elseif ($expense->frequency === 'mensuel') {
                // Charge mensuelle : compter tous les mois de l'année
                $startMonth = 1;
                $endMonth = 12;
                
                // Si la charge a commencé cette année, commencer au bon mois
                if ($expense->expense_date->year == $year) {
                    $startMonth = $expense->expense_date->month;
                }
                
                // Si la charge est inactive cette année, s'arrêter au bon mois
                if ($expense->status === 'inactif' && $expense->updated_at->year == $year) {
                    $endMonth = $expense->updated_at->month;
                }
                
                for ($month = $startMonth; $month <= $endMonth; $month++) {
                    $monthlyData[$month]['expenses'] += $expense->amount;
                }
            } elseif ($expense->frequency === 'annuel') {
                // Charge annuelle : répartir sur 12 mois ou compter le mois de paiement
                if ($expense->expense_date->year == $year) {
                    $month = $expense->expense_date->month;
                    $monthlyData[$month]['expenses'] += $expense->amount;
                } elseif ($expense->next_expense_date && $expense->next_expense_date->year == $year) {
                    $month = $expense->next_expense_date->month;
                    $monthlyData[$month]['expenses'] += $expense->amount;
                }
            }
        }
        
        // Projets terminés par mois
        $projects = Project::whereYear('end_date', $year)
            ->where('status', 'termine')
            ->get();
        
        foreach ($projects as $project) {
            if ($project->end_date) {
                $month = $project->end_date->month;
                $monthlyData[$month]['projects_count']++;
            }
        }
        
        // Distributions par mois
        $distributions = ProfitDistribution::whereYear('distribution_date', $year)->get();
        foreach ($distributions as $distribution) {
            $month = $distribution->distribution_date->month;
            $monthlyData[$month]['distributions'] += $distribution->total_profit;
            $monthlyData[$month]['abdellah_share'] += $distribution->abdellah_share;
            $monthlyData[$month]['mouad_share'] += $distribution->mouad_share;
            $monthlyData[$month]['agency_share'] += $distribution->agency_share;
            $monthlyData[$month]['sadaqah_share'] += $distribution->sadaqah_share;
        }
        
        // Calculer les bénéfices mensuels
        foreach ($monthlyData as $month => &$data) {
            $data['profit'] = $data['payments_received'] - $data['expenses'];
        }
        
        // Calculs annuels
        $totalRevenue = array_sum(array_column($monthlyData, 'payments_received'));
        $totalExpenses = array_sum(array_column($monthlyData, 'expenses'));
        $netProfit = $totalRevenue - $totalExpenses;
        $totalDistributions = array_sum(array_column($monthlyData, 'distributions'));
        $completedProjects = $projects->count();
        
        // Parts annuelles
        $yearlyShares = [
            'abdellah' => $distributions->sum('abdellah_share'),
            'mouad' => $distributions->sum('mouad_share'),
            'agency' => $distributions->sum('agency_share'),
            'sadaqah' => $distributions->sum('sadaqah_share'),
        ];
        
        return view('annual-report', compact(
            'year',
            'monthlyData',
            'totalRevenue',
            'totalExpenses',
            'netProfit',
            'totalDistributions',
            'completedProjects',
            'yearlyShares'
        ));
    }
}
