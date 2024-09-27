<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\QueryException;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Advertisement extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['business_id', 'title', 'link', 'link_title'];

    public const VALID_RELATIONS = [
        'media',
        'business',
        'business.media',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public function scopeAllowedIncludes(Builder $query, $requestIncludes): void
    {
        $relationships = explode(',', $requestIncludes);
        $diff = array_diff($relationships, Advertisement::VALID_RELATIONS);

        //throw_if(count($diff) > 0,'QueryException',['hello']);
//        if (count($diff) > 0) {
//            return response()->json([
//                'message' => 'the include field is invalid: ' . implode(',', $diff),
//            ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
//        }


        $query->with($relationships);
    }
}
