<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'image', 'is_active', 'room_type', 'created_at', 'updated_at', 'owner_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rooms_users')->select('users.id', 'full_name', 'mail', 'avatar');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->with('user')->orderBy('created_at', 'desc')->limit(15);
    }
}
