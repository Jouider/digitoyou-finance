<?php

namespace App\Http\Controllers;

use App\Models\ProfitDistribution;
use App\Models\Project;
use Illuminate\Http\Request;

class ProfitDistributionController extends Controller
{
    public function index()
    {
        $distributions = ProfitDistribution::with('project.client')->latest('distribution_date')->get();
        return view('profit-distributions.index', compact('distributions'));
    }

    public function create()
    {
        $projects = Project::with('client')->get();
        return view('profit-distributions.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'total_profit' => 'required|numeric|min:0',
            'agency_percentage' => 'required|numeric|min:0|max:100',
            'sadaqah_percentage' => 'required|numeric|min:0|max:100',
            'distribution_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        // Calcul automatique des parts
        $shares = ProfitDistribution::calculateShares(
            $validated['total_profit'],
            $validated['agency_percentage'],
            $validated['sadaqah_percentage']
        );

        ProfitDistribution::create(array_merge($validated, $shares));
        return redirect()->route('profit-distributions.index')->with('success', 'Distribution créée avec succès !');
    }

    public function show(ProfitDistribution $profitDistribution)
    {
        $profitDistribution->load('project.client');
        return view('profit-distributions.show', compact('profitDistribution'));
    }

    public function edit(ProfitDistribution $profitDistribution)
    {
        $projects = Project::with('client')->get();
        return view('profit-distributions.edit', compact('profitDistribution', 'projects'));
    }

    public function update(Request $request, ProfitDistribution $profitDistribution)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'total_profit' => 'required|numeric|min:0',
            'agency_percentage' => 'required|numeric|min:0|max:100',
            'sadaqah_percentage' => 'required|numeric|min:0|max:100',
            'distribution_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $shares = ProfitDistribution::calculateShares(
            $validated['total_profit'],
            $validated['agency_percentage'],
            $validated['sadaqah_percentage']
        );

        $profitDistribution->update(array_merge($validated, $shares));
        return redirect()->route('profit-distributions.index')->with('success', 'Distribution modifiée avec succès !');
    }

    public function destroy(ProfitDistribution $profitDistribution)
    {
        $profitDistribution->delete();
        return redirect()->route('profit-distributions.index')->with('success', 'Distribution supprimée avec succès !');
    }
}
