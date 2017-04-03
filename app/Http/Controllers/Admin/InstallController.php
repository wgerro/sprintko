<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\EnvModel;
use Cache;
use File;
use Storage;
use Artisan;
use App\User;
use App\Models\PageModel;
use App\Models\PageSubModel;
use App\Models\MediaSingleModel;
use App\Models\MediaAlbumsModel;
use App\Models\GeneralModel;
use App\Models\PostModel;
use App\Models\TemplateModel;
use App\Models\WidgetModel;
use App\Models\CategoryModel;
use Config;
class InstallController extends Controller
{
    /*
    * model: none
    * view: install
    * method: GET
    */
    public function index(){
    	return view('installs/install-1');
    }
    /*
    * model: EnvModel
    * view: install
    * method: POST
    */
    public function install(Request $request){
        $this->key_generate();
        
    	$env = new EnvModel();
    	$env->app = 'production';
    	$env->debug = 'false';
    	$env->url = url('/');
    	$env->install = 1;
    	$env->db_host = $request->host;
    	$env->db_db = $request->database;
    	$env->db_user = $request->user;
    	$env->db_pass = $request->db_password;
        $env->saveFile();
        Config::set('database.connections.mysql.host', $request->host);
        Config::set('database.connections.mysql.database', $request->database);
        Config::set('database.connections.mysql.username', $request->user);
        Config::set('database.connections.mysql.password', $request->db_password);
        $this->createFiles();
        $this->install_migrate_db();
        
        
        $user = User::create([
        	'name' => $request->login,
        	'email' => $request->email,
        	'password' => bcrypt($request->password),
        	'role' => 0
        ]);
        
        $this->install_seed_db();
        $this->importCache();
        return redirect('/admin');
    }

    /*
    * Wygenerowanie nowego klucza aplikacji
    */
    public function key_generate(){
        Artisan::call('key:generate');
        return true;
    }
    /*
    * migracja bazy danych 
    */
    public function install_migrate_db(){
    	Artisan::call('migrate');
        return true;
    }
    /*
    * migracja rekordow do tabeli
    */
    public function install_seed_db(){
    	Artisan::call('db:seed');
        return true;
    }

    /*
    * połączenie z bazą danych
    */
    public function check_db(Request $request){
        $servername = $request->host;
        $username = $request->user;
        $password = $request->db_password;
        // Create connection
        $conn = mysqli_connect($servername,$username,$password);
        // Check connection
        if (!$conn) {
           return response()->json(['status' => 0]);
        } 
        else{
           return response()->json(['status' => 1]);
        }
    }

    /*
    * Tworzenie plików
    */
    public function createFiles(){
        $storage = base_path().'/storage/app';
        $public = public_path().'/storage';

        $directories_storage = [
            'modules','modules/cookies','pages','posts','templates'
        ];

        $files_storage = [
            'main_first.txt', 'main_second.txt', 'main_three.txt', 'main_four.txt','page.txt'
        ];

        foreach($directories_storage as $directory)
        {
            if(!File::isDirectory($storage.'/'.$directory))
            {
                File::makeDirectory($storage.'/'.$directory);
                if($directory == 'templates')
                {
                    File::put($storage.'/'.$directory.'/page.txt',1);
                }
                elseif($directory == 'modules/cookies')
                {
                    File::put($storage.'/'.$directory.'/cookies.txt','cooookies');
                }
            }
        }
        return true;
    }
    /*
    * Importowanie plików cache
    */
    public function importCache(){
        //pages
        Cache::forever('pages', PageModel::orderBy('position','ASC')->with(['module','sub'=> function($query){
            $query->with('page');
        }])->where('active',1)->get());
        //pages submenus
        Cache::forever('pages-sub', PageSubModel::with(['page','page_submenu'])->get());
        //media single
        Cache::forever('media-single', MediaSingleModel::with('category')->orderBy('position','DESC')->get());
        //media albums
        Cache::forever('media-albums', MediaAlbumsModel::with(['files'=>function($query){ $query->where('active',1); },'category'])->orderBy('position','DESC')->where('active',1)->get());
        //general
        Cache::forever('global', GeneralModel::get());
        //posts
        Cache::forever('posts', PostModel::with(['post_category'=>function($query){
                return $query->with('category');
            }])->orderBy('position','DESC')->where('active',1)->get());
        //templates
        Cache::forever('template', TemplateModel::get());
        //widgets
        Cache::forever('widgets', WidgetModel::orderBy('position','ASC')->where('active',1)->get());
        //category
        Cache::forever('category', CategoryModel::get());
    }
}
