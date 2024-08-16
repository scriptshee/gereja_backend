<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $fillable = [
        'thumbnail',
        'title',
        'description',
        'content',
        'start_datetime',
        'end_datetime',
        'is_endedtime',
        'user_id',
    ];

    protected $casts = [
        'is_endedtime' => 'boolean'
    ];

    public function attendace() : HasMany
    {
        return $this->hasMany(Attandance::class, 'event_id', 'id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function scopeFilter($query, $filters)
    {
        $query->when($filters['sort'] ?? 'desc', function($query, $sort){
            if($sort === 'desc'){
                $query->latest();
            }
        });
    }
}
