<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attandance extends Model
{
    use HasFactory;

    protected $table = 'event_attendance';
    protected $fillable = [
        'event_id',
        'user_id',
        'is_present',
        'is_read',
        'read_time',
        'note'
    ];

    protected $casts = [
        'is_present' => 'boolean',
        'is_read' => 'boolean',
    ];

    public function event() : BelongsTo
    {
        return  $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
