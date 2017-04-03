<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContents extends Model
{
    protected $table = 'page_contents';
    protected $fillable = [
        'page_id',
        'file',
        'content_id',
        'page_str',
    ];
    public $timestamps = false;

	public function content(){
		return $this->belongsTo('App\Models\Contents','content_id');
	}   
}
