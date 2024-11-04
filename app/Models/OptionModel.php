<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptionModel extends Model
{
    use HasFactory;

    protected $table = 'options';
    protected $primaryKey = 'id';
    protected $fillable = [
        'option_name',
        'option_value',
        'autoload',
    ];

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
