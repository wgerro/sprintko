<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilesModel extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'album_id',
        'name',
        'active',
        'position',
        'url',
        'option'
    ];
    public $timestamps = false;

    protected $casts = [
        'active' => 'boolean',
        'position' => 'integer',
        
    ];
    
    public function albums(){
    	return $this->belongsTo('App\Models\MediaAlbumsModel','album_id');
    }
}
