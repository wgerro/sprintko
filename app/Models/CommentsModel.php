<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentsModel extends Model
{
    protected $table = 'comments';
    protected $fillable = [
        'user_id',
        'post_id',
        'nickname',
        'subject',
        'description',
        'created_at',
        'active',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer',
        'active' => 'boolean'
    ];

    public $timestamps = false;
    
    public function post(){
        return $this->belongsTo('App\Models\PostModel','post_id')->select('id','subject');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id')->select('id','name');
    }
    
}
