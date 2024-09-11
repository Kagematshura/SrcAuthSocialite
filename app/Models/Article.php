<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id', 'profile_picture']; // Make sure 'user_id' is included

    protected $table = 't_article'; // Table name if not default

    // Define the relationship to User
    public function user()
    {
        return $this->belongsTo(User::class); // Each article belongs to one user
    }
}
