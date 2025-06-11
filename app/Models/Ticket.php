<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket
 *
 * @property $id
 * @property $creator_provider_id
 * @property $assigned_provider_id
 * @property $title
 * @property $type_id
 * @property $description
 * @property $status
 * @property $solution
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property User $user
 * @property TicketType $ticketType
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Ticket extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['creator_provider_id', 'assigned_provider_id', 'title', 'type_id', 'description', 'status', 'solution'];


    // Tickets donde este usuario es el asignado
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_provider_id');
    }
    
    // Tickets donde este usuario es el creador
    public function createdTickets()
    {
        return $this->hasMany(Ticket::class, 'creator_provider_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticketType()
    {
        return $this->belongsTo(\App\Models\TicketType::class, 'type_id', 'id');
    }
    
}
