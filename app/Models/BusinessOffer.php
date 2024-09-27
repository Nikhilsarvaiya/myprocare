<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BusinessOffer extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['business_id', 'title', 'description', 'reward_point'];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Business::class, 'id', 'id','business_id','user_id');
    }
}
