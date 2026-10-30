<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Muestra la galería del porfolio (con opción de filtrar por categoría).
     */
    public function index(Request $request)
    {
        // Traemos todas las categorías para armar los botones de filtro en la vista
        $categories = EventCategory::all();

        // Empezamos la consulta de proyectos cargando su categoría para evitar el problema N+1
        $query = Project::with('category');

        // Si el usuario seleccionó una categoría específica en la web, filtramos
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Traemos los proyectos ordenados del más nuevo al más viejo
        $projects = $query->latest()->get();

        // Retornamos la vista del porfolio pasándole los datos
        return view('porfolio.index', compact('projects', 'categories'));
    }

    /**
     * Muestra el detalle de un proyecto específico (al hacer clic en una foto).
     */
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        
        return view('porfolio.show', compact('project'));
    }
}
