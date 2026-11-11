<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\EventCategory;
use App\Models\ProjectImage; 
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
    $project = Project::with(['category', 'images', 'comments'])->where('slug', $slug)->firstOrFail();

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


    // Implementaciones del 9/11, version 0.50 :v

    /**
     * Muestra el formulario de creación de un nuevo proyecto (Admin).
     */
    public function create()
    {
        // Traemos las categorías para el elemento <select> del formulario
        $categories = EventCategory::all();
        
        return view('porfolio.create', compact('categories'));
    }

    /**
     * Almacena el proyecto y sube las múltiples imágenes al disco (Admin).
     */
    public function store(Request $request)
    {
        // 1. Validamos de forma estricta el formulario
        $request->validate([
            'event_category_id' => 'required|exists:event_categories,id',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'location'          => 'nullable|string|max:255',
            'event_date'        => 'nullable|date',
            'images'            => 'required|array',
            'images.*'          => 'image|mimes:jpeg,png,jpg|max:4096', // Máximo 4MB por foto
        ]);

        // 2. Creamos el registro en la tabla de projects generando el slug dinámico
        $project = Project::create([
            'event_category_id' => $request->event_category_id,
            'title'             => $request->title,
            // Agregamos un timestamp al slug para evitar colisiones si repiten títulos
            'slug'              => Str::slug($request->title) . '-' . time(), 
            'description'       => $request->description,
            'location'          => $request->location,
            'event_date'        => $request->event_date,
            'is_featured'       => $request->has('is_featured'),
        ]);

        // 3. Subimos los archivos reales a la carpeta del servidor local
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Guarda la imagen físicamente en storage/app/public/portfolio
                $path = $image->store('portfolio', 'public');

                // Creamos el registro en la tabla secundaria que unificamos con el merge
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                ]);
            }
        }

        // Redireccionamos a la galería del porfolio avisando el éxito
        return redirect()->route('porfolio.index')
            ->with('success', '¡Excelente! La nueva ambientación fue publicada exitosamente en el porfolio.');
    }
}
