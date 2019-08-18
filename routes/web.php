<?php

// Default login routes from Auth::routes()
Route::get('/', function(){ return view('frontend.home.index');})->name('index');

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('auth.member.login');
Route::get('member/password/reset', 'Auth\member\ForgotPasswordController@showLinkRequestForm')->name('member.password.request');
Route::post('member/password/email', 'Auth\member\ForgotPasswordController@sendResetLinkEmail')->name('member.password.email');
Route::get('member/password/reset/{token}', 'Auth\member\ResetPasswordController@showResetForm')->name('auth.password.reset');
Route::post('member/password/reset', 'Auth\member\ResetPasswordController@reset')->name('member.password.reset');
Route::get('member/reset-success', 'Auth\member\ResetPasswordController@resetSuccess')->name('member.reset-success');

Route::get('admin/login', 'Auth\Admin\LoginController@showLoginForm')->name('auth.admin.login');
Route::post('admin/login', 'Auth\Admin\LoginController@login')->name('auth.admin.login');

Route::get('admin/password/reset', 'Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin/password/email', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/password/reset/{token}', 'Auth\Admin\ResetPasswordController@showResetForm')->name('auth.password.reset');
Route::post('admin/password/reset', 'Auth\Admin\ResetPasswordController@reset')->name('admin.password.reset');
Route::get('admin/reset-success', 'Auth\Admin\ResetPasswordController@resetSuccess')->name('admin.reset-success');


Route::get('sitemap.xml', 'Frontend\SiteMapController@sitemap')->name('sitemap.xml');

Route::group(['middleware' => 'auth:admin'], function() {
	
	Route::get('admin', 'Backend\AdminController@index')->name('admin');
	Route::get('admin/logout', 'Auth\Admin\LoginController@logout')->name('admin.logout');
	
	Route::namespace('Backend')->prefix('admin')->name('admin.')->group(function () {

		Route::resource('admins','AdminController');

		// News CRUD
        Route::get('news', 'NewsController@index')->name('news');
        Route::get('news/add', 'NewsController@add')->name('news.add');
        Route::post('news/create', 'NewsController@create')->name('news.create');
        Route::get('news/edit/{id}', 'NewsController@edit')->name('news.edit');
        Route::post('news/edit/update', 'NewsController@update')->name('news.update');
        Route::post('news/delete', 'NewsController@delete')->name('news.delete');

        // News Kategori CRUD
        Route::get('news-kategori', 'NewsKategoriController@index')->name('news-kategori');
        Route::get('news-kategori/add', 'NewsKategoriController@add')->name('news-kategori.add');
        Route::post('news-kategori/create', 'NewsKategoriController@create')->name('news-kategori.create');
        Route::get('news-kategori/edit/{id}', 'NewsKategoriController@edit')->name('news-kategori.edit');
        Route::post('news-kategori/update', 'NewsKategoriController@update')->name('news-kategori.update');
        Route::post('news-kategori/delete', 'NewsKategoriController@delete')->name('news-kategori.delete');

        // Produk Kategori CRUD
        Route::get('produk-kategori', 'ProdukKategoriController@index')->name('produk-kategori');
        Route::get('produk-kategori/add', 'ProdukKategoriController@add')->name('produk-kategori.add');
        Route::post('produk-kategori/create', 'ProdukKategoriController@create')->name('produk-kategori.create');
        Route::get('produk-kategori/edit/{id}', 'ProdukKategoriController@edit')->name('produk-kategori.edit');
        Route::post('produk-kategori/update', 'ProdukKategoriController@update')->name('produk-kategori.update');
        Route::post('produk-kategori/delete', 'ProdukKategoriController@delete')->name('produk-kategori.delete');

        // Members CRUD
        Route::get('members', 'MembersController@index')->name('members');
        Route::get('members/add', 'MembersController@add')->name('members.add');
        Route::post('members/create', 'MembersController@create')->name('members.create');
        Route::get('members/edit/{id}', 'MembersController@edit')->name('members.edit');
        Route::post('members/update', 'MembersController@update')->name('members.update');
        Route::post('members/delete', 'MembersController@delete')->name('members.delete');


        // Merek CRUD
        Route::get('merek', 'MerekController@index')->name('merek');
        Route::get('merek/add', 'MerekController@add')->name('merek.add');
        Route::post('merek/create', 'MerekController@create')->name('merek.create');
        Route::get('merek/edit/{id}', 'MerekController@edit')->name('merek.edit');
        Route::post('merek/update', 'MerekController@update')->name('merek.update');
        Route::post('merek/delete', 'MerekController@delete')->name('merek.delete');

        // Login histories for admin (view only)
        Route::get('login-histories-admin', 'LoginHistoryController@LoginHistoriesAdmin')->name('login-histories-admin');
    });

});