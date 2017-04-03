<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategoryModel extends Model
{
    protected $table = 'post-category';
    protected $fillable = [
        'post_id',
        'category_id',
    ];
    public $timestamps = false;

    protected $casts = [
        'post_id' => 'integer',
        'category_id' => 'integer',
    ];

    public function category(){
    	return $this->belongsTo('App\Models\CategoryModel','category_id');
    }

    public function post(){
    	return $this->belongsTo('App\Models\PostModel','post_id');
    }
}
