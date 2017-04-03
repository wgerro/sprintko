<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralModel extends Model
{
    protected $table = 'general';
    protected $fillable = [
        'articles_count',
        'api',
        'logo',
        'google_verification',
        'category_widgets',
        'article_widgets',
        'gallery_widgets',
        'search_widgets',
        'error_widgets',
        'is_comments',
    ];

    protected $casts = [
        'category_widgets' => 'boolean',
        'article_widgets' => 'boolean',
        'gallery_widgets' => 'boolean',
        'search_widgets' => 'boolean',
        'error_widgets' => 'boolean',
        'is_comments' => 'boolean',
    ];
    public $timestamps = false;

}
