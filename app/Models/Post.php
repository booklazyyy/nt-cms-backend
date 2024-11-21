<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 *
 * @property $id
 * @property $user_id
 * @property $organization_id
 * @property $type
 * @property $parent_id
 * @property $slug
 * @property $title
 * @property $excerpt
 * @property $content
 * @property $custom_css
 * @property $custom_js
 * @property $language
 * @property $status
 * @property $password
 * @property $guid
 * @property $menu_order
 * @property $ordered
 * @property $mime_type
 * @property $published_at
 * @property $published_by
 * @property $created_at
 * @property $created_by
 * @property $updated_at
 * @property $updated_by
 * @property $deleted_at
 * @property $deleted_by
 *
 * @property User $user
 * @property Organization $organization
 * @property Post $post
 * @property User $user
 * @property User $user
 * @property PostMeta[] $postmetas
 * @property Post[] $posts
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Post extends Model
{
    use SoftDeletes;

    protected $perPage = 5;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'organization_id', 'type', 'parent_id', 'slug', 'title', 'excerpt', 'data_json', 'content', 'custom_css', 'custom_js', 'language', 'status', 'guid', 'menu_order', 'ordered', 'mime_type', 'published_at', 'published_by', 'created_by', 'updated_by', 'deleted_by'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function organization()
    // {
    //     return $this->belongsTo(\App\Models\Organization::class, 'organization_id', 'id');
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function post()
    // {
    //     return $this->belongsTo(\App\Models\Post::class, 'parent_id', 'id');
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function user()
    // {
    //     return $this->belongsTo(\App\Models\User::class, 'updated_by', 'id');
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    // public function user()
    // {
    //     return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function postmetas()
    // {
    //     return $this->hasMany(\App\Models\PostMeta::class, 'id', 'post_id');
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function posts()
    // {
    //     return $this->hasMany(\App\Models\Post::class, 'id', 'parent_id');
    // }

}
