<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedArticle extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'url', 'article_data'];

    protected $casts = [
        'article_data' => 'array',
    ];
}
