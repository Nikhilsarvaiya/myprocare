<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Business extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'business_type_id',
        'restaurant_type_id',
        'food_type_id',
        'name',
        'about',
        'address',
        'latitude',
        'longitude',
        'phone',
        'website_link',
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'youtube_link',
        'tiktok_link',
        'uber_link',
        'doordash_link',
        'approved',
        'step_completed',
    ];

    protected $appends = ['total_steps'];

    public function getTotalStepsAttribute(): int
    {
        return $this->businessType->sell_food_beverage ? 6 : 5;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function businessType(): BelongsTo
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function restaurantType(): BelongsTo
    {
        return $this->belongsTo(RestaurantType::class);
    }

    public function foodType(): BelongsTo
    {
        return $this->belongsTo(FoodType::class);
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(OpeningHour::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function businessOffers(): HasMany
    {
        return $this->hasMany(BusinessOffer::class);
    }
}
