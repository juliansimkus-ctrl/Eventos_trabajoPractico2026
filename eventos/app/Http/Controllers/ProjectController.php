<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Muestra la galería del porfolio (con opción de filtrar por categoría).
     */
    public function index()
    {
    // traigo todas las categorías para armar las opciones del select
    $categories = EventCategory::all();

    $projects = Project::with('category')->latest()->get();

    return view('porfolio.index', compact('projects', 'categories'));
    }


    
    /**
     * * Muestra el detalle de un proyecto con su galería de fotos.
    */
    public function show($slug)
    {
        $project = Project::with(['category', 'images'])
        ->where('slug', $slug)
        ->firstOrFail();

    return view('porfolio.show', compact('project'));
    }
    

    //filtra usando AJAX los eventos seleccionados en index
    public function filtrar(Request $request)
    {
        $projects = Project::with('category')
        ->deCategoria($request->query('category'))
        ->latest()
        ->get();
        
        return view('porfolio._tarjetas', compact('projects'));
    }
}
