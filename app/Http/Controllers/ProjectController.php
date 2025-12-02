<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('client')->latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = Client::where('is_active', true)->orderBy('name')->get();
        return view('projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:en_cours,termine,maintenance',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        Project::create($validated);
        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès !');
    }

    public function show(Project $project)
    {
        $project->load('client', 'payments', 'profitDistributions', 'projectPayments');
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $clients = Client::where('is_active', true)->orderBy('name')->get();
        return view('projects.edit', compact('project', 'clients'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:en_cours,termine,maintenance',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);

        $project->update($validated);
        return redirect()->route('projects.index')->with('success', 'Projet modifié avec succès !');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès !');
    }
}
