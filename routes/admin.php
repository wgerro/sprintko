<?php
$admin = 'Admin\AdminController@';
$page = 'Admin\PageController@';
$category = 'Admin\CategoryController@';
$post = 'Admin\PostController@';
$albums = 'Admin\MediaAlbumsController@';
$files = 'Admin\FilesController@';
$media_single = 'Admin\MediaSingleController@';
$widgets = 'Admin\WidgetController@';
$templates = 'Admin\TemplatesController@';
$mails = 'Admin\MailController@';
$general = 'Admin\GeneralController@';
$editor = 'Admin\EditorController@';
$cookies = 'Admin\CookiesController@';
$media = 'Admin\MediaController@';
$comments = 'Admin\CommentController@';
$contents = 'Admin\ContentController@';
/*
* DASHBOARD
*/
Route::get('/', $admin.'index')->name('dashboard');
Route::get('/json', $admin.'json');

/*
* PAGES
*/
Route::get('/pages', $page.'index')->name('pages');
Route::get('/pages/json', $page.'json');
Route::get('/pages/create', $page.'create')->name('pages-create');
Route::post('/pages/create', $page.'store')->name('pages-store');
Route::get('/pages/edit/{id}', $page.'edit');
Route::put('/pages/edit/{id}', $page.'update')->name('pages-update');
Route::put('/pages/edit/position/{id}', $page.'position');
Route::put('/pages/edit/modules-position/{id}', $page.'position_modules');
Route::get('/pages/delete/{id}', $page.'destroy');

/*
* CATEGORY
*/
Route::get('/category', $category.'index')->name('category');
Route::get('/category/json', $category.'json');
Route::post('/category/create', $category.'create')->name('category-create');
Route::put('/category/edit/{id}', $category.'update');
Route::get('/category/delete/{id}', $category.'destroy');

/*
* POSTS
*/
Route::get('/posts', $post.'index')->name('posts');
Route::get('/posts/json', $post.'json');
Route::get('/posts/create', $post.'create')->name('posts-create');
Route::post('/posts/create', $post.'store')->name('posts-store');
Route::get('/posts/edit/{id}', $post.'edit');
Route::put('/posts/edit/{id}', $post.'update')->name('posts-update');
Route::put('/posts/edit/position/{id}', $post.'position');
Route::get('/posts/delete/{id}', $post.'destroy');
Route::post('/posts/upload', $post.'upload');

/*
* ALBUMS
*/
Route::get('/media-albums', $albums.'index')->name('media-albums');
Route::get('/media-albums/json', $albums.'json');
Route::post('/media-albums/create', $albums.'create')->name('media-albums-create');
Route::put('/media-albums/edit/{id}', $albums.'update');
Route::get('/media-albums/delete/{id}', $albums.'destroy');
/*
* FILES
*/
Route::get('/media-albums/files/delete/{id}', $files.'destroy');
Route::get('/media-albums/files/{id}/{option}', $files.'index')->name('files');
Route::get('/media-albums/files/json/{id}/{option}', $files.'json');
Route::post('/media-albums/files/create/{id}/{option}', $files.'create')->name('files-create');
Route::put('/media-albums/files/edit/{id}', $files.'update');


/*
* GALLERIE ONE
*/
Route::get('/media-single', $media_single.'index')->name('media-single');
Route::get('/media-single/json', $media_single.'json');
Route::post('/media-single/create', $media_single.'create')->name('media-single-create');
Route::put('/media-single/edit/{id}', $media_single.'update');
Route::get('/media-single/delete/{id}', $media_single.'destroy');

/*
* WIDGETS
*/
Route::get('/widgets', $widgets.'index')->name('widgets');
Route::get('/widgets/json', $widgets.'json');
Route::post('/widgets/create', $widgets.'create')->name('widgets-create');
Route::put('/widgets/edit/{id}', $widgets.'update');
Route::get('/widgets/delete/{id}', $widgets.'destroy');

/*
* TEMPLATES
*/
Route::get('/templates', $templates.'index')->name('templates');
Route::get('/templates/json', $templates.'json');
Route::post('/templates/create', $templates.'create')->name('templates-create');
Route::put('/templates/edit', $templates.'select')->name('templates-edit');
Route::get('/templates/delete/{id}', $templates.'destroy');

/* 
* MAILS
*/
Route::get('/mails', $mails.'index')->name('mails');
Route::get('/mails/json', $mails.'json');
Route::put('/mails/edit/{form}', $mails.'update')->name('mails-edit');
Route::post('/mails/send', $mails.'send')->name('mails-send');

/*
* GENERAL
*/
Route::get('/general', $general.'index')->name('general');
Route::get('/general/json', $general.'json');
Route::put('/general/update', $general.'update')->name('general-update');
Route::put('/general/update-api', $general.'update_api')->name('general-api');

/*
* EDITOR
*/
Route::get('/editor-html', $editor.'index')->name('editor');
Route::get('/editor-html/json', $editor.'json');
Route::get('/editor-html/json/open/{editor}/{path}', $editor.'open');
Route::post('/editor-html/save', $editor.'save')->name('editor-save');

/*
* POLICY COOKIES
*/
Route::get('/policy-cookies', $cookies.'index')->name('cookies');
Route::put('/policy-cookies/update', $cookies.'update')->name('cookies-update');

/*
* MEDIA
*/
Route::get('/media', $media.'index')->name('media');
Route::get('/media/json', $media.'json');
Route::post('/media/create', $media.'create')->name('media-create');
Route::get('/media/download/{file}', $media.'download');
Route::get('/media/delete/{file}', $media.'destroy');

/*
* COMMENTS
*/
Route::get('/comments', $comments.'index')->name('comments');
Route::get('/comments/json', $comments.'json');
Route::put('/comments/edit/{id}', $comments.'update');
Route::get('/comments/delete/{id}', $comments.'destroy');

/*
* DOKUMENTACJA
*/
Route::get('/documentation', function(){
	return view('admin.doc');
})->name('doc');

/*
* CONTENTS
*/
Route::get('/contents', $contents.'index')->name('contents');
Route::post('/contents', $contents.'create')->name('contents-create');
Route::get('/contents/json', $contents.'json');
Route::put('/contents/edit/{id}', $contents.'edit');
Route::get('/contents/delete/{id}', $contents.'destroy');

/*
* PAGE CONTENTS
*/
Route::get('/contents/page-contents/view/{id}', $contents.'view_page_contents');
Route::post('/contents/page-contents/edit', $contents.'edit_page_contents')->name('contents-page-edit');
Route::put('/contents/page-contents/edit/file', $contents.'save_file_page_contents')->name('contents-page-edit-file');
