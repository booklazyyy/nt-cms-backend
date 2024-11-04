<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Template
 *
 * @property $id
 * @property $name
 * @property $thumbnail
 * @property $data
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Template extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'thumbnail', 'data'];


}
