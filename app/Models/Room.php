<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
      'name', 'description', 'image', 'is_active', 'room_type'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rooms_users');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
