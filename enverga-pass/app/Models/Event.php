<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'location',
        'organizer',
        'category',
        'event_date',
        'banner_image',
        'total_capacity',
        'requires_tuition_clearance',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'requires_tuition_clearance' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function ticketTypes()
    {
        return $this->hasMany(TicketType::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
