<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Project $project)
    {
    if (!$project->canReceiveComments()) {
        return back()->withErrors([
            'content' => 'El período de 7 días para comentar este evento ya finalizó.'
        ]);
    }

    $validated = $request->validate([
        'author_name' => 'required|string|min:2|max:100',
        'content'     => 'required|string|min:5|max:500',
    ]);

    $project->comments()->create($validated);

    return back()->with('success', '¡Gracias por dejar tu comentario sobre el evento!');
    }
}