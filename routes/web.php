<?php
	$main = 'GerroController@';
	$mails = 'Admin\MailController@';

	Auth::routes();
	Route::get('search', $main.'search')->name('search');
	Route::get('sitemap', 'SitemapController@index');
	
	Route::get('{slug?}', $main.'index');
	Route::get('/json/{module?}/{slug?}', $main.'json');
	// module = article, gallerie, slug
	Route::get('/{module?}/{slug?}', $main.'show');
	//zablokowac storage, article, gallery

	//wysyłka mailowa
	Route::post('/send-mail', $mails.'get')->name('send-mail');

	//dodawanie komentarzy
	Route::post('/create-comment', $main.'addComment')->name('add-comment');

	//pobranie pliku
	Route::post('/download', $main.'download')->name('download');