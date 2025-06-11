<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property $id
 * @property $name
 * @property $lastname
 * @property $status
 * @property $email
 * @property $email_verified_at
 * @property $password
 * @property $remember_token
 * @property $created_at
 * @property $updated_at
 *
 * @property Ticket[] $tickets
 * @property Ticket[] $tickets
 * @property Slot[] $slots
 * @property StreamSlot[] $streamSlots
 * @property Tip[] $tips
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'lastname', 'status', 'email', 'password',];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets_assigned_provider()
    {
        return $this->hasMany(\App\Models\Ticket::class, 'id', 'assigned_provider_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets_creator_provider()
    {
        return $this->hasMany(\App\Models\Ticket::class, 'id', 'creator_provider_id');
    }

        protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
        protected $hidden = [
        'password',
        'remember_token',
    ];
}
