<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Project;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
public function run(): void
{
    $projects = Project::whereNotNull('event_date')->get();

    foreach ($projects as $project) {
        Comment::create([
            'project_id'  => $project->id,
            'author_name' => 'Invitado de prueba',
            'content'     => '¡Hermosa ambientación! Cada detalle estuvo increíble.',
        ]);
    }
}
}