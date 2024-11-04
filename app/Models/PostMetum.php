<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostMetum
 *
 * @property $id
 * @property $post_id
 * @property $meta_key
 * @property $meta_value
 * @property $created_at
 * @property $updated_at
 *
 * @property Post $post
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PostMetum extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['post_id', 'meta_key', 'meta_value'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(\App\Models\Post::class, 'post_id', 'id');
    }
    
}
