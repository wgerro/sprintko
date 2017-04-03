<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateModel extends Model
{
    protected $table = 'templates';
    protected $fillable = [
        'name',
        'folder'
    ];
    public $timestamps = false;
}
