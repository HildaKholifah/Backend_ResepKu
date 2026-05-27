<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'recipe_id',
        'comment',
    ];

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi ke recipe
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}