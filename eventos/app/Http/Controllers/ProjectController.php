<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\EventCategory;
use App\Models\ProjectImage; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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


    // =========================================================================
    // PANEL DE ADMINISTRACIÓN: LISTAR, EDITAR Y ELIMINAR
    // =========================================================================

    /**
     * Muestra la tabla de administración de todos los proyectos.
     */
    public function adminIndex()
    {
        $projects = Project::with(['category', 'images'])->latest()->get();

        return view('porfolio.admin', compact('projects'));
    }

    /**
     * Muestra el formulario para editar un proyecto existente.
     */
    public function edit(Project $project)
    {
        $categories = EventCategory::all();

        return view('porfolio.edit', compact('project', 'categories'));
    }

    /**
     * Actualiza los datos del proyecto y agrega nuevas fotos si se subieron.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'event_category_id' => 'required|exists:event_categories,id',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'location'          => 'nullable|string|max:255',
            'event_date'        => 'nullable|date',
            'images'            => 'nullable|array',
            'images.*'          => 'image|mimes:jpeg,png,jpg|max:4096',
        ]);

        $project->update([
            'event_category_id' => $request->event_category_id,
            'title'             => $request->title,
            'description'       => $request->description,
            'location'          => $request->location,
            'event_date'        => $request->event_date,
            'is_featured'       => $request->has('is_featured'),
        ]);

        // Si la administradora subió fotos adicionales, las sumamos a la galería
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('portfolio', 'public');

                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', '¡Proyecto actualizado correctamente!');
    }

    /**
     * Elimina el proyecto de la base de datos y borra sus archivos de imagen.
     */
    public function destroy(Project $project)
    {
        // 1. Borramos las fotos físicas del disco local
        foreach ($project->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        // 2. Eliminamos el registro (en cascada borra sus imágenes y comentarios)
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'El proyecto fue eliminado del porfolio.');
    }
}
