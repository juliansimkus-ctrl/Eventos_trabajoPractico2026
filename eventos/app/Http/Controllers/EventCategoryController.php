<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::withCount(['projects', 'bookings'])->latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255|unique:event_categories,name',
            'description'     => 'nullable|string|max:500',
            'base_price'      => 'required|numeric|min:0',
            'price_per_guest' => 'required|numeric|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        EventCategory::create($validated);

        return back()->with('success', '¡Categoría de evento creada correctamente!');
    }

    public function edit(EventCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, EventCategory $category)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255|unique:event_categories,name,' . $category->id,
            'description'     => 'nullable|string|max:500',
            'base_price'      => 'required|numeric|min:0',
            'price_per_guest' => 'required|numeric|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', '¡Categoría actualizada correctamente!');
    }

    public function destroy(EventCategory $category)
    {
        // Evitamos borrar una categoría si ya tiene proyectos o presupuestos vinculados
        if ($category->projects()->exists() || $category->bookings()->exists()) {
            return back()->withErrors([
                'error' => 'No se puede eliminar esta categoría porque tiene proyectos o presupuestos asociados.'
            ]);
        }

        $category->delete();

        return back()->with('success', 'La categoría fue eliminada.');
    }
}