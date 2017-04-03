<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageModel extends Model
{
	protected $table = 'pages';
    protected $fillable = [
        'name',
        'slug',
        'title',
        'description',
        'keyword',
        'robots',
        'active',
        'position',
        'category_id',
        'is_widgets'
    ];

    protected $casts = [
        'category_id' => 'integer',
        'position' => 'integer',
        'active' => 'boolean',
        'robots' => 'boolean',
        'is_widgets' => 'boolean',
        
    ];

    public $timestamps = false;
    /*
    * CategoryModel - id = category_id
    */
    public function category(){
        return $this->belongsTo('App\Models\CategoryModel','category_id');
    }
    
    public function module(){
        return $this->hasMany('App\Models\PageModuleModel','page_id')->orderBy('position');
    }

    public function sub(){
        return $this->hasOne('App\Models\PageSubModel','page_id');
    }

    public function sub_id(){
        return $this->hasOne('App\Models\PageSubModel','page_sub_id');
    }

    public function contents(){
        return $this->hasMany('App\Models\PageContents','page_id');
    }

    public function page_sub_id(){
        return $this->hasMany('App\Models\PageSubModel','page_sub_id');
    }
}
