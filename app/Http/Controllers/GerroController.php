<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\PageModel;
use App\Models\WidgetModel;
use App\Models\PostCategoryModel;
use App\Models\PostModel;
use App\Models\MediaAlbumsModel;
use App\Models\FilesModel;
use App\Models\CategoryModel;
use App\Models\MediaSingleModel;
use App\Models\TemplateModel;
use Cache;
use Storage;
use App\Models\VisitsModel;
use App\Models\PaginateModel;
use App\Models\GeneralModel;
use App\Models\PageSubModel;
use App\Models\CommentsModel;
use App\Models\PageContents;
use Auth;
class GerroController extends Controller
{
    public $cache = [
        'pages',
        'widgets',
        'template',
        'media-single',
        'albums',
        'global',
        'post-category',
        'posts',
        'category',
        'comments'
    ];
    public $check_template, $check_menus, $check_submenus, $check_article, $check_albums, $check_widgets, $check_media_single, $check_global, $check_category, $appFacebook, $check_comments;

    public function __construct(){
        if(env('INSTALL')!=null)
        {
            $visit = new VisitsModel();
            $visit::check();
        }
        $this->check_template = Cache::has('template');
        $this->check_menus = Cache::has('pages');
        $this->check_submenus = Cache::has('pages-sub');
        $this->check_article = Cache::has('posts');
        $this->check_albums = Cache::has('media-albums');
        $this->check_widgets = Cache::has('widgets');
        $this->check_media_single = Cache::has('media-single');
        $this->check_global = Cache::has('global');
        $this->check_category = Cache::has('category');
        $this->appFacebook = env('API_FACEBOOK_APP');
        $this->check_comments = Cache::has('comments');
    }
    /***************************************
    *           OBSŁUGA STRONY 
    *
    * - jeśli brak slugu to wyswietli sie glowna strona
    * - jeśli jest slug to wyswietli sie konkretna strona
    ****************************************/
    public function index(Request $request, $slug=null){

        /* template */
        $id = Storage::get('templates/page.txt'); // ustawianie id template
        $template = $this->check_template ? collect(Cache::get('template'))->where('id',(int)$id)->first() : TemplateModel::find((int)$id); //pobranie template

        /* menus */
        $menus = $this->check_menus ? collect(Cache::get('pages')) : PageModel::orderBy('position','ASC')->with(['module','sub'])->where('active',1)->get();
        $menus_sub = $this->check_submenus ? collect(Cache::get('pages-sub')) : PageSubModel::get();

        /* widgets */
        $widgets = $this->check_widgets ? collect(Cache::get('widgets')) : WidgetModel::orderBy('position','ASC')->where('active',1)->get();
        
        /* general global */
        $global = $this->check_global ? collect(Cache::get('global'))->first() : GeneralModel::find(1);
        $checkApi = $global->api == 'sprintko' ? false : true;
        $pageLogo = $global->logo;
        $googleVerification = $global->google_verification;

        /* ustawianie paginacji */
        $paginate = new PaginateModel();
        $paginate->ilosc_rekordow_na_stronie = $global->articles_count;
        $paginate->aktualna_strona = !$request->has('page') || $request->page==0 ? 1 : $request->page;

        /* category */
        $category = $this->check_category ? collect(Cache::get('category')) : CategoryModel::get(); 

        /* 5 ostatnich postów */
        $latest_posts = collect(Cache::get('posts'))->take(5);

        /* comments */
        if(!$checkApi)
        {
            $comments = $this->check_comments ? collect(Cache::get('comments')) : CommentsModel::with('user')->where('active',1)->get();
        }
        else{
            $comments = '';
        }

    //jesli nie ma slugu
        if($slug==null)
    	{
            /* pobranie wybranej strony */
                $page = $this->check_menus ? collect(Cache::get('pages'))->where('slug',' ')->first() : PageModel::with(['module','sub'])->where('slug',' ')->first();
            
            /* gallerie one */
                $media_single = $this->check_media_single ? collect(Cache::get('media-single')) : MediaSingleModel::orderBy('position','DESC')->get();

            /* POSTS - tworzenie tabeli wraz z tabelą post-category */
                $data = $this->check_article ? collect(Cache::get('posts')) : PostModel::with(['post_category'=>function($query){
                    return $query->with('category');
                }])->orderBy('position','DESC')->where('active',1)->get();
            
                $table = [];

                foreach($data as $key=>$post)
                {
                    $table[$key] = [
                        'created_at'=>$post->created_at, 
                        'id'=>$post->id, 
                        'user_id'=>$post->user_id,
                        'image'=>$post->image,
                        'subject'=>$post->subject,
                        'slug'=>$post->slug,
                        'description'=>$post->description,
                        'category'=>[]
                    ];

                    foreach($post->post_category as $p_c)
                    {
                        array_push($table[$key]['category'], $p_c->category->name);
                    }
                }
            /* paginate */
                $paginate->ilosc_rekordow = collect($table)->count();
                $posts = collect($table)->sortByDesc('position')->forPage($paginate->aktualna_strona, $paginate->ilosc_rekordow_na_stronie);

            /* ALBUMS */
                $albums = $this->check_albums ? collect(Cache::get('media-albums')) : MediaAlbumsModel::orderBy('position','DESC')->get();
    	}
    	else{ //jesli jest podstrona
            
            /* pobranie wlasnej strony */
                $page = $this->check_menus ? collect(Cache::get('pages'))->where('slug',$slug)->first() : PageModel::with('module')->where('slug',$slug)->first();
            
            /* jesli istnieje jakas strona, jesli nie to wyskoczy informacja abort(404) */
                if(count($page))
                {
                	if($page->category_id == null) //jesli kategoria pusta 
            		{
                        /* gallerie one */
                            $media_single = $this->check_media_single ? collect(Cache::get('media-single')) : MediaSingleModel::orderBy('position','DESC')->get();

                        /* posts */
                            $data = $this->check_article ? collect(Cache::get('posts')) : PostModel::with(['post_category'=>function($query){
                                return $query->with('category');
                            }])->orderBy('position','DESC')->where('active',1)->get();
                            
                            $table = [];
                            foreach($data as $key=>$post)
                            {
                                $table[$key] = [
                                    'created_at'=>$post->created_at, 
                                    'id'=>$post->id, 
                                    'user_id'=>$post->user_id,
                                    'image'=>$post->image,
                                    'subject'=>$post->subject,
                                    'slug'=>$post->slug,
                                    'description'=>$post->description,
                                    'category'=>[]
                                ];

                                foreach($post->post_category as $p_c)
                                {
                                    array_push($table[$key]['category'], $p_c->category->name);
                                }
                            }
                        /* paginate */
                            $paginate->ilosc_rekordow = collect($table)->count();

                        $posts = collect($table)->sortByDesc('position')->forPage($paginate->aktualna_strona, $paginate->ilosc_rekordow_na_stronie);

                        /* albums */
                            $albums = $this->check_albums ? collect(Cache::get('media-albums')) : MediaAlbumsModel::orderBy('position','DESC')->get();
            		}
            		else{ //jesli jest kategoria

                        /* gallerie one */
                            $media_single = $this->check_media_single ? collect(Cache::get('media-single'))->where('category_id', $page->category_id) : MediaSingleModel::orderBy('position','DESC')->get();

                        /* posts */
                            $data = $this->check_article ? collect(Cache::get('posts')) : PostModel::with(['post_category'=>function($query){
                                return $query->where('category_id', $page->category_id)->with('category');
                            }])->orderBy('position','DESC')->where('active',1)->get();
                        
                            $table = [];

                            foreach($data as $key=>$post)
                            {
                                $id = false;
                                foreach($post->post_category->where('category_id',$page->category_id) as $p_c)
                                {
                                    if($post->id == $p_c->post_id)
                                    {
                                         $table[$key] = [
                                            'created_at'=>$post->created_at, 
                                            'id'=>$post->id, 
                                            'user_id'=>$post->user_id,
                                            'image'=>$post->image,
                                            'subject'=>$post->subject,
                                            'slug'=>$post->slug,
                                            'description'=>$post->description,
                                            'category'=>[]
                                        ];
                                        $id = true;
                                    }
                                    array_push($table[$key]['category'], $p_c->category->name);
                                }
                            }
                        /* paginate */
                            $paginate->ilosc_rekordow = collect($table)->count();
                        
                        $posts = collect($table)->sortByDesc('position')->forPage($paginate->aktualna_strona, $paginate->ilosc_rekordow_na_stronie);

                        /* albums */
                            $albums = $this->check_albums ? collect(Cache::get('media-albums'))->where('category_id',$page->category_id) : MediaAlbumsModel::where('category_id',$page->category_id)->orderBy('position','DESC')->get();
            	    }
                }
                else{
                    abort(404);
                }
        }
        /* contenty */
        $query = Cache::remember('contents-new', 20 , function() {
            return PageContents::with('content')->get();
        });
        $contents = collect($query)->where('page_id', (int)$page->id);


    	return view('templates.'.$template->folder.'.content')
    		->with([
    			'page' => $page,
    			'menus' => $menus,
    			'widgets' => $widgets,
    			'posts' => $posts,
    			'media_single' => $media_single,
    			'albums' => $albums,
                'template' => 'templates.'.$template->folder.'.',
                'prevent_paginate' => $paginate->prevent($slug),
                'next_paginate' => $paginate->next($slug),
                'numbers_paginate' => $paginate->numbers($slug),
                'actual' => $paginate->aktualna_strona,
                'paginator' => $paginate->check(),
                'checkApi' => $checkApi,
                'pageLogo' => $pageLogo,
                'googleVerification' => $googleVerification,
                'template_public' => $template->folder,
                'submenus'=>$menus_sub,
                'category' => $category,
                'global'=> $global,
                'latest_posts' => $latest_posts,
                'appFacebook' => $this->appFacebook,
                'comments' => $comments,
                'contents' => $contents //TUTAJ
    		]);
    }
    /************************************************
    *    ----> OBSŁUGA MODUŁÓW <----
    *
    *************************************************/
    public function show(Request $request, $module=null, $slug=null){
        $block_slugs = ['article','albums','category'];
        if(!in_array($module, $block_slugs))
        {
            abort(404);
        }
        /* category */
        $category = $this->check_category ? collect(Cache::get('category')) : CategoryModel::get();
        /* widgets */
        $widgets = $this->check_widgets ? collect(Cache::get('widgets')) : WidgetModel::orderBy('position','ASC')->where('active',1)->get();
        $id = Storage::get('templates/page.txt');
        $template = $this->check_template ? collect(Cache::get('template'))->where('id',(int)$id)->first() : TemplateModel::find((int)$id);
        $menus = $this->check_menus ? collect(Cache::get('pages')) : PageModel::orderBy('position','ASC')->with(['module','sub'])->where('active',1)->get();
        $menus_sub = $this->check_submenus ? collect(Cache::get('pages-sub')) : PageSubModel::get();
        $global = $this->check_global ? collect(Cache::get('global'))->first() : GeneralModel::find(1);
        $checkApi = $global->api == 'sprintko' ? false : true;
        $pageLogo = $global->logo;
        $googleVerification = $global->google_verification;
        $latest_posts = collect(Cache::get('posts'))->take(5);
    	switch($module)
    	{
    		case 'article':
    		{
                $article = $this->check_article ? collect(Cache::get('posts'))->where('slug',$slug)->first() : PostModel::where('slug',$slug)->first();
                if(count($article) == 0)
                {
                    abort(404);
                }
                //komentarze
                if(!$checkApi)
                {
                    $comments = $this->check_comments ? collect(Cache::get('comments'))->where('post_id',$article->id) : CommentsModel::where('post_id',$article->id)->with('user')->where('active',1)->get();
                }
                else{
                    $comments = '';
                }
                
    			return view('templates.'.$template->folder.'.article')
    				->with([
                        'menus' => $menus,
                        'template' => 'templates.'.$template->folder.'.',
                        'checkApi' => $checkApi,
                        'pageLogo' => $pageLogo,
                        'googleVerification' => $googleVerification,
                        'article' => $article,
                        'template_public' => $template->folder,
                        'submenus'=>$menus_sub,
                        'category'=>$category,
                        'widgets'=>$widgets,
                        'global'=> $global,
                        'latest_posts' => $latest_posts,
                        'appFacebook' => $this->appFacebook,
                        'comments' => $comments
                    ]);

    		}
    		break;

    		case 'albums':
    		{
                $albums = $this->check_albums ? collect(Cache::get('media-albums'))->where('slug',$slug)->first() : MediaAlbumsModel::with(['files','category'])->where('slug',$slug)->first();
                if(count($albums) == 0)
                {
                    abort(404);
                }
    			return view('templates.'.$template->folder.'.album')
                    ->with([
                        'menus' => $menus,
                        'template' => 'templates.'.$template->folder.'.',
                        'checkApi' => $checkApi,
                        'pageLogo' => $pageLogo,
                        'googleVerification' => $googleVerification,
                        'albums' => $albums,
                        'template_public' => $template->folder,
                        'submenus'=>$menus_sub,
                        'category'=>$category,
                        'widgets'=>$widgets,
                        'global'=> $global,
                        'latest_posts' => $latest_posts,
                        'appFacebook' => $this->appFacebook
                    ]);
    		}
    		break;
            /* lista kategorii */
            case 'category':
            {
                $paginate = new PaginateModel();
                $paginate->ilosc_rekordow_na_stronie = $global->articles_count;
                $paginate->aktualna_strona = !$request->has('page') || $request->page==0 ? 1 : $request->page;

                $category_first = $this->check_category ? collect(Cache::get('category'))->where('slug',$slug)->first() : CategoryModel::where('slug',$slug)->first();

                if(count($category_first) == 0)
                {
                    abort(404);
                }

                $data = $this->check_article ? collect(Cache::get('posts')) : PostModel::with(['post_category'=>function($query){
                        return $query->where('category_id', $category_first->id)->with('category');
                    }])->orderBy('position','DESC')->where('active',1)->get();
                    
                    $table = [];

                    foreach($data as $key=>$post)
                    {
                        $id = false;
                        foreach($post->post_category->where('category_id',$category_first->id) as $p_c)
                        {
                            if($post->id == $p_c->post_id)
                            {
                                 $table[$key] = [
                                    'created_at'=>$post->created_at, 
                                    'id'=>$post->id, 
                                    'user_id'=>$post->user_id,
                                    'image'=>$post->image,
                                    'subject'=>$post->subject,
                                    'slug'=>$post->slug,
                                    'description'=>$post->description,
                                    'category'=>[]
                                ];
                                $id = true;
                            }
                            array_push($table[$key]['category'], $p_c->category->name);
                        }
                    }
                //paginate
                $paginate->ilosc_rekordow = collect($table)->count();
                $posts = collect($table)->sortByDesc('position')->forPage($paginate->aktualna_strona, $paginate->ilosc_rekordow_na_stronie);

                $albums = $this->check_albums ? collect(Cache::get('media-albums'))->where('category_id',$category_first->id) : MediaAlbumsModel::where('category_id',$category_first->id)->orderBy('position','DESC')->get();
                //komentarze
                if(!$checkApi)
                {
                    $comments = $this->check_comments ? collect(Cache::get('comments')) : CommentsModel::with('user')->where('active',1)->get();
                }
                else{
                    $comments = '';
                }

                /* gallerie one */
                $media_single = $this->check_media_single ? collect(Cache::get('media-single'))->where('category_id', $category_first->id) : MediaSingleModel::orderBy('position','DESC')->get();


                return view('templates.'.$template->folder.'.category')
                    ->with([
                        'menus' => $menus,
                        'template' => 'templates.'.$template->folder.'.',
                        'checkApi' => $checkApi,
                        'pageLogo' => $pageLogo,
                        'googleVerification' => $googleVerification,
                        'albums' => $albums,
                        'posts' => $posts,
                        'template_public' => $template->folder,
                        'submenus'=>$menus_sub,
                        'category_first'=> $category_first,
                        'category'=>$category,
                        'widgets'=>$widgets,
                        'prevent_paginate' => $paginate->prevent($slug),
                        'next_paginate' => $paginate->next($slug),
                        'numbers_paginate' => $paginate->numbers($slug),
                        'actual' => $paginate->aktualna_strona,
                        'paginator' => $paginate->check(),
                        'global'=> $global,
                        'latest_posts' => $latest_posts,
                        'appFacebook' => $this->appFacebook,
                        'comments' => $comments,
                        'media_single' => $media_single,
                    ]);
            }
            break;





    	}
    }
    /*********************************************************************************************
    * ODBIERANIE DANYCH ZA POMOCĄ JSONA
    * MODULY: articles, albums, album z slug, media_single
    * URL : /json/articles
    * URL : /json/albums
    * URL : /json/album/slug
    * URL : /json/media-single
    *     
    **********************************************************************************************/
    public function json($module=null, $slug=null){
        $global = $this->check_global ? collect(Cache::get('global'))->first() : GeneralModel::find(1);
        $checkApi = $global->api == 'sprintko' ? false : true;
        switch($module)
        {
            //wszystkie artykuly
            case 'articles':
            {
                /* POSTS - tworzenie tabeli wraz z tabelą post-category */
                $data = $this->check_article ? collect(Cache::get('posts')) : PostModel::with(['post_category'=>function($query){
                    return $query->with('category');
                }])->orderBy('position','DESC')->where('active',1)->get();
                
                $table = [];
                //komentarze
                if(!$checkApi)
                {
                    $comments = $this->check_comments ? collect(Cache::get('comments')) : CommentsModel::with('user')->where('active',1)->get();
                }
                else{
                    $comments = 0;
                }
                foreach($data as $key=>$post)
                {
                    $table[$key] = [
                        'created_at'=>$post->created_at, 
                        'id'=>$post->id, 
                        'user_id'=>$post->user_id,
                        'image'=>$post->image,
                        'subject'=>$post->subject,
                        'slug'=>$post->slug,
                        'description'=>$post->description,
                        'comments_count' => $comments->where('post_id',$post->id)->count(),
                        'category'=>[]
                    ];

                    foreach($post->post_category as $p_c)
                    {
                        array_push($table[$key]['category'], $p_c->category->name);
                    }
                }

                return $table;
            }
            //wszystkie albumy
            case 'albums':
            {
                $albums = $this->check_albums ? collect(Cache::get('media-albums')) : MediaAlbumsModel::orderBy('position','DESC')->get();
                return $albums;
            }
            break;
            //konkrenty album z konkretnym slug
            case 'album':
            {
                $album = $this->check_albums ? collect(Cache::get('media-albums'))->where('slug',$slug)->first() : MediaAlbumsModel::with(['files','category'])->where('slug',$slug)->first();
                return $album;
            }
            break;
            //pojedyncze media
            case 'media-single':
            {
                $media_single = $this->check_media_single ? collect(Cache::get('media-single')) : MediaSingleModel::orderBy('position','DESC')->get();
                return $media_single;
            }

        }
    }
    /***********************************************************************************************************
    * WYSZUKIWARKA
    * /search
    * ZA POMOCA GET
    *    
    *************************************************************************************************************/
    public function search(Request $request)
    {
        $id = Storage::get('templates/page.txt');
        $template = $this->check_template ? collect(Cache::get('template'))->where('id',(int)$id)->first() : TemplateModel::find((int)$id);

        $menus = $this->check_menus ? collect(Cache::get('pages')) : PageModel::orderBy('position','ASC')->with(['module','sub'])->where('active',1)->get();
        $menus_sub = $this->check_submenus ? collect(Cache::get('pages-sub')) : PageSubModel::get();

        $global = $this->check_global ? collect(Cache::get('global'))->first() : GeneralModel::find(1);
        $checkApi = $global->api == 'sprintko' ? false : true;
        $pageLogo = $global->logo;
        $googleVerification = $global->google_verification;

        $text = $request->search;

        $widgets = $this->check_widgets ? collect(Cache::get('widgets')) : WidgetModel::orderBy('position','ASC')->where('active',1)->get();

        /* POSTS - tworzenie tabeli wraz z tabelą post-category */
        $data = PostModel::with(['post_category'=>function($query){
            return $query->with('category');
        }])->orderBy('position','DESC')->where('subject','like','%'.$text.'%')->where('active',1)->get();
                
        $table = [];

        //komentarze
        if(!$checkApi)
        {
            $comments = $this->check_comments ? collect(Cache::get('comments')) : CommentsModel::with('user')->where('active',1)->get();
        }
        else{
            $comments = '';
        }

        foreach($data as $key=>$post)
        {
            $table[$key] = [
                'created_at'=>$post->created_at, 
                'id'=>$post->id, 
                'user_id'=>$post->user_id,
                'image'=>$post->image,
                'subject'=>$post->subject,
                'slug'=>$post->slug,
                'description'=>$post->description,
                'category'=>[]
            ];

            foreach($post->post_category as $p_c)
            {
                array_push($table[$key]['category'], $p_c->category->name);
            }
        }
        
        $posts = $table;
        $latest_posts = collect(Cache::get('posts'))->take(5);

        /* ALBUMS */
        $albums = MediaAlbumsModel::orderBy('position','DESC')->where('name','like','%'.$text.'%')->with(['files','category'])->get();

        $category = $this->check_category ? collect(Cache::get('category')) : CategoryModel::get();

        return view('templates.'.$template->folder.'.view-search')
            ->with([
                'menus' => $menus,
                'template' => 'templates.'.$template->folder.'.',
                'checkApi' => $checkApi,
                'pageLogo' => $pageLogo,
                'posts' => $posts,
                'albums' => $albums,
                'googleVerification' => $googleVerification,
                'submenus'=>$menus_sub,
                'global'=> $global,
                'widgets'=>$widgets,
                'latest_posts'=>$latest_posts,
                'appFacebook' => $this->appFacebook,
                'category' => $category,
                'comments' => $comments
            ]);
              
    }
    /**********************************************
        -----> DODAWANIE KOMENTARZY <-----

    ***********************************************/
    public function addComment(Request $request)
    {
        CommentsModel::create([
            'user_id'=> Auth::check() ? Auth::user()->id : null,
            'post_id'=> $request->post_id,
            'nickname'=> $request->has('nickname') ? $request->nickname : '',
            'subject' => $request->subject,
            'description'=> $request->description,
            'created_at' => date('Y-m-d H:i:s'),
            'active' => 1,
        ]);
        Cache::forever('comments', CommentsModel::with('user')->where('active',1)->orderBy('id','DESC')->get());
        return redirect()->back();

    }
    /********************************************
    *
    * MOŻLIWOŚC POBRANIA PLIKU JAKIEGOŚ
    *
    *********************************************/
    public function download(Request $request)
    {
        if(str_contains($request->file, 'storage'))
        {
            return response()->download(public_path().$request->file);
        }
        else
        {
            return redirect()->back();
        }
    }
}
