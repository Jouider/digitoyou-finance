<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::latest()->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:abonnement,hebergement,domaine,materiel,logiciel,autre',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:mensuel,annuel,unique',
            'expense_date' => 'required|date',
            'next_expense_date' => 'nullable|date|after:expense_date',
            'status' => 'required|in:actif,inactif'
        ]);

        Expense::create($validated);
        return redirect()->route('expenses.index')->with('success', 'Charge créée avec succès !');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:abonnement,hebergement,domaine,materiel,logiciel,autre',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:mensuel,annuel,unique',
            'expense_date' => 'required|date',
            'next_expense_date' => 'nullable|date|after:expense_date',
            'status' => 'required|in:actif,inactif'
        ]);

        $expense->update($validated);
        return redirect()->route('expenses.index')->with('success', 'Charge modifiée avec succès !');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Charge supprimée avec succès !');
    }
}
