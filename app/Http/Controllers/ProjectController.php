<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver proyectos')->only(['index', 'show']);
        $this->middleware('permission:crear proyectos')->only(['create', 'store']);
        $this->middleware('permission:editar proyectos')->only(['edit', 'update']);
        $this->middleware('permission:eliminar proyectos')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['client', 'user'])->orderBy('created_at', 'desc')->paginate(15);
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('company')->get();
        $users = User::orderBy('name')->get();
        return view('projects.create', compact('clients', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['client', 'user', 'tasks.assignedUser']);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $clients = Client::orderBy('company')->get();
        $users = User::orderBy('name')->get();
        return view('projects.edit', compact('project', 'clients', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,cli_id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:planning,active,on_hold,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
