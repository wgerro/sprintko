<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'name',
        'description',
        'slug',
    ];
    public $timestamps = false;
    
    
    public function post_category(){
    	return $this->belongsTo('App\Models\PostCategoryModel', 'category_id');
    }
}
