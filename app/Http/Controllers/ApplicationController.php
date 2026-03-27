<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::withCount('services')->paginate(10);
        return view('applications.index', compact('applications'));
    }

    public function create()
    {
        return view('applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Application::create($validated);

        return redirect()->route('applications.index')->with('success', 'Nueva aplicación registrada exitosamente.');
    }

    public function edit(Application $application)
    {
        return view('applications.edit', compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $application->update($validated);

        return redirect()->route('applications.index')->with('success', 'Datos de la aplicación actualizados.');
    }

    public function destroy(Application $application)
    {
        $application->delete();
        return redirect()->route('applications.index')->with('success', 'Aplicación SaaS eliminada.');
    }
}
