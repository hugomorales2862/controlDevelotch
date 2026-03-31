<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Application;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('application')->paginate(15);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $applications = Application::all();
        return view('services.create', compact('applications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string|max:500',
            'price'          => 'required|numeric|min:0',
            'duration_days'  => 'required|integer|min:1',
            'type'           => 'nullable|in:hosting,dominio,soporte,desarrollo,mantenimiento,otro',
            'billing_cycle'  => 'nullable|in:weekly,monthly,yearly,triennial',
            'features'       => 'nullable|string',
        ]);

        Service::create($validated);

        return redirect()->route('services.index')
            ->with('success', '✅ Plan registrado exitosamente.');
    }

    public function show(Service $service)
    {
        $service->load(['application', 'subscriptions.client']);
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $applications = Application::all();
        return view('services.edit', compact('service', 'applications'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'application_id' => 'required|exists:applications,id',
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string|max:500',
            'price'          => 'required|numeric|min:0',
            'duration_days'  => 'required|integer|min:1',
            'type'           => 'nullable|in:hosting,dominio,soporte,desarrollo,mantenimiento,otro',
            'billing_cycle'  => 'nullable|in:weekly,monthly,yearly,triennial',
            'features'       => 'nullable|string',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')
            ->with('success', '✅ Plan "' . $service->name . '" actualizado correctamente.');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')
            ->with('success', '🗑️ Plan eliminado exitosamente.');
    }
}
