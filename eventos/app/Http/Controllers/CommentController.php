<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    public function store(Request $request, Project $project)
    {
        if (!$project->canReceiveComments()) {
            return back()->withErrors([
                'content' => 'El período de 7 días para comentar este evento ya finalizó.'
            ]);
        }

        $palabrasProhibidas = config('moderation.palabras_prohibidas', []);

        $filtroGroserias = function (string $attribute, mixed $value, \Closure $fail) use ($palabrasProhibidas) {
            // 1. Quitamos tildes y pasamos a minúsculas
            $textoLimpio = Str::ascii(mb_strtolower($value));

            // 2. Normalizamos reemplazos típicos de evasión (ej: @ -> a, 3 -> e, 1 -> i, 0 -> o, $ -> s)
            $textoNormalizado = strtr($textoLimpio, [
                '@' => 'a',
                '4' => 'a',
                '3' => 'e',
                '1' => 'i',
                '!' => 'i',
                '0' => 'o',
                '$' => 's',
                '5' => 's',
            ]);

            foreach ($palabrasProhibidas as $palabra) {
                if (preg_match('/\b' . preg_quote($palabra, '/') . '\b/i', $textoNormalizado)) {
                    $fail('El mensaje contiene lenguaje inapropiado que no está permitido en la galería.');
                    break;
                }
            }
        };

        $validated = $request->validate([
            'author_name' => ['required', 'string', 'min:2', 'max:100', $filtroGroserias],
            'content'     => ['required', 'string', 'min:5', 'max:500', $filtroGroserias],
        ]);

        $project->comments()->create($validated);

        return back()->with('success', '¡Gracias por dejar tu comentario sobre el evento!');
    }
}