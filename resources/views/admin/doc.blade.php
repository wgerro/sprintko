@extends('admin.index')


@section('css')
<style>
.nav>li>a:hover,
.nav>li>a:focus {
    text-decoration: none;
    background-color: #008703;
    color:white;
}
.nav>li.active>a{
	background: #008703;
	color:white;
}
</style>
@endsection

@section('content')
<div class="col-xs-12 col-md-12 col-sm-12" id="app">
	<div class="row">
	    <div class="panel panel-default panel-ko">
	        <div class="panel-heading panel-ko-heading">
				<ol class="breadcrumb">
					  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><span class="label label-default">Admin</span></a></li>
					  <li class="breadcrumb-item active"><span class="label label-success">Documentation</span></li>
				</ol>
	            <h1 class="text-center"> DOCUMENTATION </h1>
	        </div>
	    </div>
	</div>
</div>

<div class="col-xs-12 col-md-2 ">
	<div class="row">
	<div class="panel panel-default panel-ko">
		<div class="panel-body">
			<ul class="nav">
			    <li class="active"><a data-toggle="pill" href="#install">1. INSTALACJA</a></li>
			    <li><a data-toggle="pill" href="#create-themes">2. TWORZENIE SZABLONU</a></li>
			    <li><a data-toggle="pill" href="#create-widgets">3. TWORZENIE WIDGETÓW</a></li>
			    
			    <li><a data-toggle="pill" href="#menu1">. </a></li>
			</ul>
			  
			
		</div>
	</div>
	</div>
</div>

<div class="col-xs-12 col-md-10">
	<div class="panel panel-default panel-ko">
		<div class="panel-body">
			<div class="tab-content">
			    <div id="install" class="tab-pane fade in active">
			    	<h3>WYMAGANIA</h3>
			    	<ul>
			    		<li> PHP >= 5.6.4 </li>
						<li> OpenSSL PHP Extension </li>
						<li> PDO PHP Extension </li>
						<li> Mbstring PHP Extension </li>
						<li> Tokenizer PHP Extension </li>
						<li> XML PHP Extension </li>
						<li> Laravel 5.3.* </li>
					</ul>

			      	<h3>INSTALACJA</h3>
			      	<p>1. Zainstalować laravela na swoim serwerze ( laravel 5.3.* ) ze strony githuba <a href="https://github.com/laravel/laravel.git" class="btn btn-xs btn-danger" target="_blank"> POBIERZ </a></p>
			      	<p>2. Pobrać sprintko ze strony githuba <a href="https://github.com/wgerro/sprintko.git" class="btn btn-xs btn-danger" target="_blank"> POBIERZ </a></p>
			      	<p>3. Wypakować wszystkie pliki sprintko na serwer gdzie jest zainstalowany laravel</p>

			    </div>
			    <div id="create-themes" class="tab-pane fade">
			      <h3>TWORZENIE SZABLONU</h3>
			      <p class="text-center"><b>Struktura plików</b></p>
			      <div class="text-center">
			      	<img src="{{ asset('doc/structure.png') }}">
			      </div>
			      <hr>
			      <h3 class="text-center">OGÓLNIE</h3>

			      <p><kbd>index.blade.php</kbd> - główny plik</p>
			      <p><kbd>article.blade.php</kbd> - wyswietlenie konkretnego artykułu</p>
			      <p><kbd>category.blade.php</kbd> - wyswietlenie konkretnej kategorii</p>
			      <p><kbd>content.blade.php</kbd> - wyswietlenie konkretnej strony </p>
			      <p><kbd>error.blade.php</kbd> - wyswietlenie błędu 404</p>
			      <p><kbd>footer.blade.php</kbd> - stopka </p>
			      <p><kbd>gallery.blade.php</kbd> - wyswietlnie konkretnej galerii ze zdjeciami</p>
			      <p><kbd>header.blade.php</kbd> - główka </p>
			      <p><kbd>view-search.blade.php</kbd> - wyswietlenie wyników wpisanych przez klienta</p>
			      <hr>
			      <h3 class="text-center">MODUŁY</h3>
			      <p><kbd>articles.blade.php</kbd> - wyswietlenie wszystkich artykułów</p>
			      <p><kbd>cookies.blade.php</kbd> - wyswietlenie informacji o ciasteczkach cookies</p>
			      <p><kbd>form-contact.blade.php</kbd> - wyswietlenie formularza kontaktowego</p>
			      <p><kbd>gallery-albums.blade.php</kbd> - wyswietlenie wszystkich albumów</p>
			      <p><kbd>gallery-one.blade.php</kbd> - wyswietlenie pojedynczej galerii</p>
			      <hr>
			      <h3 class="text-center">WIDGETY</h3>
			      <p><kbd>latest-post.blade.php</kbd> - wyswietlenie 5 ostatnich postow</p>
			      <p><kbd>list-category.blade.php</kbd> - wyswietlenie listy kategorii</p>
			      <p><kbd>search.blade.php</kbd> - wyswietlenie formularza wyszukiwania słów</p>
			      <p><kbd>social-media.blade.php</kbd> - wyswietlenie ikonów portali spolecznosciowych</p>
			      <hr>
			      <h3 class="text-center"> DEFINIOWANIE ZMIENNYCH </h3>
			      <?php
			      $table = [
			      	1=>[
			      		'zmienna'=>'<code>$page (first)</code>',
			      		'ok_zm'=>'<code>$page->title</code> (string) - tytuł strony <br> <code>$page->description</code> (string) - opis strony <br> <code>$page->keywords</code> (string) - klucze słowa <br> <code>$page->robots</code> (boolean) - czy istnieją roboty <br> <code>$page->slug</code> (string) - slug strony <br> <code> $page->content_first, $page->content_second, $page->content_three, $page->content_four </code> (string) - wlasny tekst html <br> <code> $page->is_widgets </code> (boolean)- czy istnieją widgety na konkrentej stronie <br> <code> $page->module(foreach) </code> - rozpisanie modułow <br> <code> include($template."modules.articles") </code> - wczytywanie konkrentego modułu z konkretnej strony',
			      		'dost'=>'<kbd>content.blade.php</kbd>'
			      		],
			      	2=>[
			      		'zmienna'=>'<code>$menus (foreach)</code>',
			      		'ok_zm'=>'<code>$menu->slug == null</code> - sprawdzenie czy menu posiada submenu <br> <code> $menu->name </code> - nazwa menu <br> <code>$submenus->where("page_sub_id", $menu->id)->count() > 0 </code> - sprawdzenie czy istnieje submena <br>
			      		<code>foreach($submenus->where("page_sub_id", $menu->id) as $submenu)</code> - rozpisanie submenu o wybranym id z menu <br> 
			      		<code>$submenu->page_submenu->name</code> - nazwa menu <br>
			      		<code>foreach($submenus->where("page_sub_id", $submenu->page_id) as $submenu2) </code>- rozpisanie drugiego submenu o wybranym id z submenu <br>
			      		<code> $submenu2->page_submenu->name </code> - nazwa submenu drugiego
			      		',
			      		'dost'=>'<kbd>all</kbd>'
			      		],
			      	3=>[
			      		'zmienna'=>'<code>$widgets (foreach)</code>',
			      		'ok_zm'=>'<code> foreach($widgets as $widget) <br> { <br> include($template."widgets.".$widget->file); <br> } </code> - rozpisanie widgetów i wczytywanie z wybranej templatki <br> <code> $widget->name </code> - nazwa widgetu ',
			      		'dost'=>'<kbd>all</kbd>'
			      		],
			      	3=>[
			      		'zmienna'=>'<code>$posts (foreach)</code>',
			      		'ok_zm'=>'<code> foreach($posts as $post) <br> { <br>  <br> } </code> - rozpisanie postów <br> <code> $post["slug"] </code> - slug artykułu <br>
			      			<code> $post["subject"]</code> - tytuł posta <br> <code> $post["id"] </code> - id posta <br><code> Storage::get("posts/".$post["description"])</code> - opis posta <br> <code> $comments->where("post_id", $post["id"])->count()</code> - ilość komentarzy dla wybranego id posta (działa tylko jak jest włączone api dla sprintko) <code> asset("storage/posts/".$post["image"]) </code> - wyswietlenie zdjecia <br>
			      		',
			      		'dost'=>'<kbd>articles.blade.php</kbd>'
			      		],
			      	4=>[
			      		'zmienna'=>'<code>$gallerie_one (foreach)</code>',
			      		'ok_zm'=>'<code> foreach($gallerie_one as $gallery) <br> { <br>  <br> } </code> - rozpisanie zdjec z pojedynczej galerii <br> <code> url("storage/galleries-one/".$gallery->image) </code> - wyświetlenie zdjęcia <br><code> $gallery->name </code> - tytuł zdjecia ',
			      		'dost'=>'<kbd>gallery-one.blade.php</kbd>'
			      		],
			      	5=>[
			      		'zmienna'=>'<code></code>',
			      		'ok_zm'=>'<code></code>',
			      		'dost'=>'<kbd></kbd>'
			      	]

			      ];
			      ?>
			      <table class="table table-hover">
			      	<thead>
			      		<tr>
			      			<th>Zmienna</th>
			      			<th>Określanie zmiennych</th>
			      			<th>Dostępność</th>
			      		</tr>
			      	</thead>
			      	<tbody>
			      	@foreach($table as $tab)
			      		<tr>
			      			<td>{!! $tab['zmienna'] !!}</td>
			      			<td>{!! $tab['ok_zm'] !!}</td>
			      			<td>{!! $tab['dost'] !!}</td>
			      		</tr>
			      	@endforeach
			      	</tbody>
			      </table>

			    </div>

			    	
			</div>
		</div>
	</div>
</div>


@endsection