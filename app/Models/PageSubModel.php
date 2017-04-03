<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSubModel extends Model
{

    protected $table = 'page-sub';
    protected $fillable = [
        'page_id',
        'page_sub_id'
    ];
    public $timestamps = false;

    protected $casts = [
        'page_id' => 'integer',
        'page_sub_id' => 'integer',
    ];

    public function page(){
        return $this->belongsTo('App\Models\PageModel', 'page_sub_id')->select('id','name');
    }

    public function page_submenu(){
        return $this->belongsTo('App\Models\PageModel', 'page_id')->select('id','name','slug');
    }
}
