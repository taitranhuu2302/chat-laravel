<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'due_date', 'created_at'];

    protected $dates = ['due_date', 'created_at'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_tasks')->select('users.id', 'full_name', 'email', 'avatar');
    }

}
