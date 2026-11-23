<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'event_category_id', 
        'title', 
        'slug', 
        'description', 
        'location', 
        'event_date', 
        'is_featured',
        'image'
    ];

    // Casteamos el campo is_featured a booleano y la fecha a objeto Carbon
    protected $casts = [
        'is_featured' => 'boolean',
        'event_date' => 'date',
    ];

    //RELACIONES

    /**
     * El proyecto pertenece a una categoría de evento.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }


    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }
    
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    //ATRIBUTOS INTELIGENTES

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
        get: fn () => $this->image ? asset('storage/' . $this->image) : null
        );
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => [
            'title' => trim($value),
            'slug'  => Str::slug($value),
            ]
        );
    }

    //SCOPES
    #[Scope]
    protected function deCategoria(Builder $query, $categoriaId): void
    {
        if ($categoriaId) {
            $query->where('event_category_id', $categoriaId);
            }
    }
    
    #[Scope]
    protected function destacados(Builder $query): void
    {
        $query->where('is_featured', true);
    }
    

    public function canReceiveComments(): bool
    {
        if (!$this->event_date) {
        return false;
        }
        
        $deadline = $this->event_date->copy()->addDays(7)->endOfDay();
        
        return now()->between($this->event_date->copy()->startOfDay(), $deadline);
    }
}
