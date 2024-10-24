<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Centers extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'goal',
    ];

    public $sortable = ['id', 'name', 'capacity', 'goal'];
}
