<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'room_id', 'text', 'message_type'];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select('id', 'full_name', 'email', 'avatar');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class)->select('source', 'message_id');
    }
}
