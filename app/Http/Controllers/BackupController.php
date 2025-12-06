<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use App\Models\Project;
use App\Models\Expense;
use App\Models\ProfitDistribution;
use App\Models\ProjectPayment;
use App\Models\FundMovement;
use App\Models\User;

class BackupController extends Controller
{
    public function index()
    {
        return view('backup.index');
    }

    public function export()
    {
        try {
            $data = [
                'clients' => Client::all()->toArray(),
                'projects' => Project::all()->toArray(),
                'expenses' => Expense::all()->toArray(),
                'profit_distributions' => ProfitDistribution::all()->toArray(),
                'project_payments' => ProjectPayment::all()->toArray(),
                'fund_movements' => FundMovement::all()->toArray(),
                'users' => User::all()->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        // Password is hashed, we'll keep it
                        'password' => $user->password,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at,
                    ];
                })->toArray(),
                'export_date' => now()->toDateTimeString(),
                'app_version' => '1.0.0'
            ];

            $filename = 'digitoyou-finance-backup-' . date('Y-m-d-His') . '.json';
            
            return response()->json($data, 200, [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'export: ' . $e->getMessage());
        }
    }

    public function exportSql()
    {
        try {
            $dbPath = database_path('database.sqlite');
            
            if (!file_exists($dbPath)) {
                return back()->with('error', 'Base de données introuvable');
            }

            $filename = 'digitoyou-finance-backup-' . date('Y-m-d-His') . '.sqlite';
            
            return response()->download($dbPath, $filename);

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'export SQL: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:json',
        ]);

        try {
            $file = $request->file('backup_file');
            $content = file_get_contents($file->getRealPath());
            $data = json_decode($content, true);

            if (!$data || !isset($data['export_date'])) {
                return back()->with('error', 'Fichier de sauvegarde invalide');
            }

            DB::beginTransaction();

            // Clear existing data (except users to avoid lockout)
            FundMovement::truncate();
            ProjectPayment::truncate();
            ProfitDistribution::truncate();
            Expense::truncate();
            Project::truncate();
            Client::truncate();

            // Import clients
            foreach ($data['clients'] as $client) {
                Client::create($client);
            }

            // Import projects
            foreach ($data['projects'] as $project) {
                Project::create($project);
            }

            // Import expenses
            foreach ($data['expenses'] as $expense) {
                Expense::create($expense);
            }

            // Import profit distributions
            foreach ($data['profit_distributions'] as $distribution) {
                ProfitDistribution::create($distribution);
            }

            // Import project payments
            foreach ($data['project_payments'] as $payment) {
                ProjectPayment::create($payment);
            }

            // Import fund movements
            foreach ($data['fund_movements'] as $movement) {
                FundMovement::create($movement);
            }

            // Import users (only new ones, don't overwrite existing)
            foreach ($data['users'] as $userData) {
                User::firstOrCreate(
                    ['email' => $userData['email']],
                    $userData
                );
            }

            DB::commit();

            return back()->with('success', 'Données importées avec succès! Total: ' . 
                count($data['clients']) . ' clients, ' .
                count($data['projects']) . ' projets, ' .
                count($data['expenses']) . ' dépenses');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }
}
