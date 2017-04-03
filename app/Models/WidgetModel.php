<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetModel extends Model
{
    protected $table = 'widgets';
    protected $fillable = [
        'name',
        'active',
        'position',
        'file'
    ];
    protected $casts = [
        'position' => 'integer',
        'active' => 'boolean'
    ];
    public $timestamps = false;

}
