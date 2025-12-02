<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectPayment;
use Illuminate\Http\Request;

class ProjectPaymentController extends Controller
{
    public function index()
    {
        $projectPayments = ProjectPayment::with('project.client')
            ->orderBy('payment_date', 'desc')
            ->paginate(20);
        
        return view('project-payments.index', compact('projectPayments'));
    }

    public function create()
    {
        $projects = Project::with('client')->get();
        return view('project-payments.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'type' => 'required|in:avance,partiel,final,reste',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:especes,virement,cheque,autre',
            'notes' => 'nullable|string'
        ]);

        ProjectPayment::create($validated);

        return redirect()
            ->route('project-payments.index')
            ->with('success', 'Paiement client enregistré avec succès !');
    }

    public function show(ProjectPayment $projectPayment)
    {
        $projectPayment->load('project.client');
        return view('project-payments.show', compact('projectPayment'));
    }

    public function edit(ProjectPayment $projectPayment)
    {
        $projects = Project::with('client')->get();
        return view('project-payments.edit', compact('projectPayment', 'projects'));
    }

    public function update(Request $request, ProjectPayment $projectPayment)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'type' => 'required|in:avance,partiel,final,reste',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:especes,virement,cheque,autre',
            'notes' => 'nullable|string'
        ]);

        $projectPayment->update($validated);

        return redirect()
            ->route('project-payments.index')
            ->with('success', 'Paiement client modifié avec succès !');
    }

    public function destroy(ProjectPayment $projectPayment)
    {
        $projectPayment->delete();

        return redirect()
            ->route('project-payments.index')
            ->with('success', 'Paiement client supprimé avec succès !');
    }
}
