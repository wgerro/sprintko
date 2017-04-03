<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaAlbumsModel extends Model
{
    protected $table = 'media-albums';
    protected $fillable = [
        'category_id',
        'name',
        'url',
        'slug',
        'active',
        'position',
        'type'
    ];
    public $timestamps = false;
    
    protected $casts = [
        'active' => 'boolean',
        'position' => 'integer',
    ];

    public function category(){
    	return $this->belongsTo('App\Models\CategoryModel', 'category_id');
    }

    public function files(){
        return $this->hasMany('App\Models\FilesModel', 'album_id');
    }
}
