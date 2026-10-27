<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class eventCategory extends Model
{
    // Permitimos la asignación masiva de estos campos
    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Una categoría tiene muchos proyectos en el porfolio.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Una categoría puede tener muchas solicitudes de contacto/cotización.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
