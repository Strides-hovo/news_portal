<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereRaw(string $string, array $array)
 */
class News extends Model
{
    protected $fillable = [
        'source',
        'image',
        'preview',
        'content',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
