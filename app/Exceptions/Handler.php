<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Models\TemplateModel;
use Storage;
use App\Models\PageModel;
use App\Models\WidgetModel;
use Cache;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if(env('INSTALL') == 1)
        {
            $id = Storage::get('templates/page.txt');
            $template = Cache::has('template') ? collect(Cache::get('template'))->where('id',(int)$id)->first() : TemplateModel::find((int)$id);

            $menus = Cache::has('pages') ? collect(Cache::get('pages')) : PageModel::orderBy('position','ASC')->with(['module','sub'])->where('active',1)->get();
            $menus_sub = Cache::get('pages-sub') ? collect(Cache::get('pages-sub')) : PageSubModel::get();
            $widgets = Cache::has('widgets') ? collect(Cache::get('widgets')) : WidgetModel::orderBy('position','ASC')->where('active',1)->get();
            $global = Cache::has('global') ? collect(Cache::get('global'))->first() : GeneralModel::find(1);
            $checkApi = $global->api == 'none' ? false : true;
            $pageLogo = $global->logo;
            $googleVerification = $global->google_verification;
            $category = Cache::has('category') ? collect(Cache::get('category')) : CategoryModel::get();
                $data = Cache::has('posts') ? collect(Cache::get('posts')) : PostModel::with(['post_category'=>function($query){
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
            $posts = $table;
            $latest_posts = collect(Cache::get('posts'))->take(5);
            /*

            $exception = \Symfony\Component\Debug\Exception\FlattenException::create($e);
            $statusCode = $exception->getStatusCode($exception);
            // 404 page when a model is not found
            return response()->view('templates.'.$template->folder.'.error', ['menus'=>$menus,'submenus'=>$menus_sub, 'widgets'=>$widgets, 'error_code'=>$statusCode, 'checkApi' => $checkApi,'pageLogo' => $pageLogo,'googleVerification' => $googleVerification,'category' => $category,
                    'global'=> $global,'posts'=>$posts,'template' => 'templates.'.$template->folder.'.'], $statusCode);
            
            */
            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                return response()->view('templates.'.$template->folder.'.error', ['menus'=>$menus,'submenus'=>$menus_sub, 'widgets'=>$widgets, 'error_code'=>404, 'checkApi' => $checkApi,'pageLogo' => $pageLogo,'googleVerification' => $googleVerification,'category' => $category,
                    'global'=> $global,'posts'=>$posts,'latest_posts'=>$latest_posts,'template' => 'templates.'.$template->folder.'.', 'template_public' => $template->folder], 404);
            }
        }
       return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
