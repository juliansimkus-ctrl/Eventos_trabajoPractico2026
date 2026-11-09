<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Booking extends Model
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

    //calculamos el precio estimado
    protected function precioEstimado(): Attribute
    {
        return Attribute::make(
        get: fn () => $this->category->base_price
                    + ($this->estimated_guests ?? 0) * $this->category->price_per_guest
        );
    }
}
