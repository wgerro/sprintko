<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $fillable = [
        'user_id',
        'image',
        'subject',
        'slug',
        'description',
        'position',
        'active',
    ];
    
    protected $casts = [
        'user_id' => 'integer',
        'position' => 'integer',
        'active' => 'boolean'
    ];

    public function post_category(){
        return $this->hasMany('App\Models\PostCategoryModel', 'post_id');
    }

    public function comment_count(){
        return $this->hasMany('App\Models\CommentsModel','post_id')->select('id');
    }
}
