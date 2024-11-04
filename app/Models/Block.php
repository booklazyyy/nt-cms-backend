<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Block
 *
 * @property $id
 * @property $label
 * @property $media
 * @property $content
 * @property $category
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Block extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['label', 'media', 'content', 'category'];


}
