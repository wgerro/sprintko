<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\EnvModel;
use Cache;
use File;
use Storage;
use Artisan;
use App\User;
use App\Models\PageModel;
use App\Models\PageSubModel;
use App\Models\GallerieOneModel;
use App\Models\GallerieAlbumsModel;
use App\Models\GeneralModel;
use App\Models\PostModel;
use App\Models\TemplateModel;
use App\Models\WidgetModel;
use App\Models\CategoryModel;

class SitemapController extends Controller
{   
    public function index(){
        $url = 'aaaa';
        $urls = [
            url('/')
        ];

        foreach(collect(Cache::get('pages')) as $menu)
        {
            if($menu->id != 1)
            {
                array_push($urls, action('GerroController@index',['slug'=>$menu->slug]));
            }
        }

        foreach(collect(Cache::get('posts')) as $post)
        {
            array_push($urls, action('GerroController@show',['module'=>'article','slug'=>$post->slug]));
        }

        foreach(collect(Cache::get('gallerie-albums')) as $gallery)
        {
            array_push($urls, action('GerroController@show',['module'=>'gallery','slug'=>$gallery->slug]));
        }

        foreach(collect(Cache::get('category')) as $category)
        {
            array_push($urls, action('GerroController@show',['module'=>'category','slug'=>$category->slug]));
        }   

        $sitemap = '<urlset
                        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        foreach($urls as $url)
        {
            $sitemap .= '<url><loc>'.$url.'</loc></url>';
        }
        $sitemap .= '</urlset>';
        return response($sitemap)->header('Content-Type', 'text/xml');
    }
}
