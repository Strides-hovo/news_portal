<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereRaw(string $string, array $array)
 * @method static where(string $string, string $string1, mixed $id)
 * @method static paginate(int $int)
 * @property int $id
 * @property string $preview
 * @property string $title
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
