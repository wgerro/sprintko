<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaSingleModel extends Model
{
    protected $table = 'media-single';
    protected $fillable = [
        'name',
        'active',
        'position',
        'url',
        'type',
        'category_id',
        'option'
    ];
    protected $casts = [
        'active' => 'boolean',
        'position' => 'integer',
        
    ];
    public $timestamps = false;

    public function category(){
        return $this->belongsTo('App\Models\CategoryModel', 'category_id');
    }
}
