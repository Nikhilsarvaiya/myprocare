<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Students extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'fname',
        'lname',
        'room',
        'enrollment_status',
        'type',
        'address',
        'adminssion_date',
        'graduation_date',
    ];

    public $sortable = ['id', 'fname', 'lname'];
}