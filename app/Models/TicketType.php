<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TicketType
 *
 * @property $id
 * @property $name
 * @property $status
 * @property $created_at
 * @property $updated_at
 *
 * @property Ticket[] $tickets
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TicketType extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'status'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // ✅ CORRECTO
    public function tickets()
    {
        return $this->hasMany(\App\Models\Ticket::class, 'type_id', 'id');
    }
    
}
