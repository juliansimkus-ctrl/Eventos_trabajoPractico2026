<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class booking extends Model
{
    protected $fillable = [
        'event_category_id',
        'client_name',
        'client_email',
        'client_phone',
        'estimated_date',
        'estimated_guests',
        'ideas_or_details',
        'status'
    ];

    protected $casts = [
        'estimated_date' => 'date',
    ];

    /**
     * La solicitud de cotización pertenece a una categoría de evento específica.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }
}
