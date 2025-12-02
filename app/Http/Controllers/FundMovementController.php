<?php

namespace App\Http\Controllers;

use App\Models\FundMovement;
use App\Models\ProjectPayment;
use App\Models\Expense;
use App\Models\ProfitDistribution;
use Illuminate\Http\Request;

class FundMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $balances = FundMovement::getAllBalances();
        
        $movements = FundMovement::with(['projectPayment.project', 'expense', 'profitDistribution'])
            ->orderBy('movement_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('fund-movements.index', compact('balances', 'movements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projectPayments = ProjectPayment::with('project')->get();
        $expenses = Expense::all();
        
        return view('fund-movements.create', compact('projectPayments', 'expenses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'person' => 'required|in:abdellah,mouad,agency',
            'type' => 'required|in:entree,sortie,distribution,versement_agence',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'project_payment_id' => 'nullable|exists:project_payments,id',
            'expense_id' => 'nullable|exists:expenses,id',
            'profit_distribution_id' => 'nullable|exists:profit_distributions,id',
            'movement_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        FundMovement::create($validated);

        return redirect()->route('fund-movements.index')
            ->with('success', 'Mouvement de fonds enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FundMovement $fundMovement)
    {
        $fundMovement->load(['projectPayment.project', 'expense', 'profitDistribution']);
        
        return view('fund-movements.show', compact('fundMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FundMovement $fundMovement)
    {
        $projectPayments = ProjectPayment::with('project')->get();
        $expenses = Expense::all();
        
        return view('fund-movements.edit', compact('fundMovement', 'projectPayments', 'expenses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FundMovement $fundMovement)
    {
        $validated = $request->validate([
            'person' => 'required|in:abdellah,mouad,agency',
            'type' => 'required|in:entree,sortie,distribution,versement_agence',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'project_payment_id' => 'nullable|exists:project_payments,id',
            'expense_id' => 'nullable|exists:expenses,id',
            'profit_distribution_id' => 'nullable|exists:profit_distributions,id',
            'movement_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $fundMovement->update($validated);

        return redirect()->route('fund-movements.index')
            ->with('success', 'Mouvement de fonds mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundMovement $fundMovement)
    {
        $fundMovement->delete();

        return redirect()->route('fund-movements.index')
            ->with('success', 'Mouvement de fonds supprimé avec succès.');
    }

    /**
     * Transfer funds to agency
     */
    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'from_person' => 'required|in:abdellah,mouad',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        // Check if person has enough balance
        $balance = FundMovement::getBalance($validated['from_person']);
        if ($balance < $validated['amount']) {
            return back()->with('error', 'Solde insuffisant pour ce transfert.');
        }

        // Create debit for person
        FundMovement::create([
            'person' => $validated['from_person'],
            'type' => 'versement_agence',
            'amount' => $validated['amount'],
            'description' => 'Versement vers fonds agence',
            'movement_date' => now(),
            'notes' => $validated['notes']
        ]);

        // Create credit for agency
        FundMovement::create([
            'person' => 'agency',
            'type' => 'entree',
            'amount' => $validated['amount'],
            'description' => 'Versement depuis ' . ucfirst($validated['from_person']),
            'movement_date' => now(),
            'notes' => $validated['notes']
        ]);

        return redirect()->route('fund-movements.index')
            ->with('success', 'Transfert effectué avec succès.');
    }
}
