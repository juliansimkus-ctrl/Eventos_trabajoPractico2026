<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'event_category_id', 
        'title', 
        'slug', 
        'description', 
        'location', 
        'event_date', 
        'is_featured'
    ];

    // Casteamos el campo is_featured a booleano y la fecha a objeto Carbon
    protected $casts = [
        'is_featured' => 'boolean',
        'event_date' => 'date',
    ];

    /**
     * El proyecto pertenece a una categoría de evento.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
}
