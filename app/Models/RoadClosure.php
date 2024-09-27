<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoadClosure extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'start_time', 'end_time', 'start_latitude', 'start_longitude', 'end_latitude', 'end_longitude'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
