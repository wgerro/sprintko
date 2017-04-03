<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contents extends Model
{
    protected $table = 'contents';
    protected $fillable = [
        'name'
    ];
    public $timestamps = false;

    public function page_contents(){
    	return $this->hasMany('App\Models\PageContents', 'content_id');
    }
}
