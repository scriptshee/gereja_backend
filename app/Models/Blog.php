<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'content',
        'category_id',
        'user_id',
        'published_date',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }
}
