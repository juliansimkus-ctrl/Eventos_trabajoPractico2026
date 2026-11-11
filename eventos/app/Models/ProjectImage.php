<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute; 

class ProjectImage extends Model
{
   protected $fillable = ['project_id', 'image_path', 'descripcion'];
   
   public function project(): BelongsTo
   {
    return $this->belongsTo(Project::class);
    }

    protected function url(): Attribute
    {
        return Attribute::make(
        get: fn () => asset('storage/' . $this->image_path)
        );
    }
}
