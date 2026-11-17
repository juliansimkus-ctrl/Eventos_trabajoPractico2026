<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
        ]);

        Service::create($validated);

        return back()->with('success', '¡Servicio agregado correctamente!');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'price'       => 'required|numeric|min:0',
        ]);

        $service->update($validated);

        return redirect()->route('admin.services.index')
            ->with('success', '¡Servicio actualizado correctamente!');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', 'El servicio fue eliminado.');
    }
}