<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageModuleModel extends Model
{
	/* Modules
    * 1 - articles
    * 2 - galleries with albums
    * 3 - gallerie one
    */
    protected $table = 'pages-modules';
    protected $fillable = [
        'page_id',
        'module',
        'position'
    ];
    public $timestamps = false;
    protected $casts = [
        'page_id' => 'integer',
        'module' => 'integer',
        'position' => 'integer',
    ];
}
