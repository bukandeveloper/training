<?php

Route::group(['middleware' => 'auth:admin'], function() {

    Route::get('/admins/getAdminsTabular', 'Api\ApiAdminsController@getAdminsTabular');
    Route::post('/login-histories/getAdminLoginHistoriesTabular', 'Api\ApiAdminLoginHistoriesController@getAdminLoginHistoriesTabular');

    // news
    Route::get('/news/getNewsTabular', 'Api\ApiNewsController@getNewsTabular');
    // Login histories for admin
    Route::post('/login-histories/getAdminLoginHistoriesTabular', 'Api\ApiAdminLoginHistoriesController@getAdminLoginHistoriesTabular');

    // members
    Route::get('/members/getMembersTabular', 'Api\ApiMembersController@getMembersTabular');

    // news kategori
    Route::get('/news-kategori/getNewsKategoriTabular', 'Api\ApiNewsKategoriController@getNewsKategoriTabular');
    // news kategori
    Route::get('/produk-kategori/getProdukKategoriTabular', 'Api\ApiProdukKategoriController@getProdukKategoriTabular');
    Route::get('/produk-kategori/getOngkir', 'Api\ApiProdukKategoriController@getOngkir');
    // merek
    Route::get('/merek/getMerekTabular', 'Api\ApiMerekController@getMerekTabular');
});
