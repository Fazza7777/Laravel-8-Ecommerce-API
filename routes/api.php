<?php


use Illuminate\Support\Facades\Route;


## For Not Auth
Route::group(['namespace'=>'Admin'],function(){

    Route::post('/login','ApiController@login');
    Route::post('/register','ApiController@register');

    Route::get('/categories','ApiController@categories');
    Route::get('/subcats','ApiController@subcats');
    Route::get('/subcat/{id}','ApiController@subCategories');
    Route::get('/tags','ApiController@tags');
    Route::get('/products','ApiController@products');
    Route::get('/product/{id}','ApiController@productById');
    Route::get('/productByCat/{id}','ApiController@productByCategory');
    Route::get('/productBySubCat/{id}','ApiController@productBysubCat');
    Route::get('/productByTag/{id}','ApiController@productByTag');
    Route::get('/productByAllTag/{id}','ApiController@productByAllTag');
});

## For If Auth

Route::group(['middleware'=>'jwt.auth',"namespace"=>"Admin"],function(){
    Route::get('/me','ApiController@me');
    Route::post('/order', 'ApiController@setOrder');
    Route::get('/myOrder', 'ApiController@myOrder');
    Route::get('/orderItemByOrderId/{id}', 'ApiController@orderItemByorderId');

    Route::post('/save-product', 'ApiController@saveProduct');
    Route::post('/unsave-product', 'ApiController@unsaveProduct');

    Route::get('/getSaveProduct', 'ApiController@getSaveProduct');

    Route::post('/profile-update', 'ApiController@updateProfile');
    Route::post('/change-password', 'ApiController@changePassword');
});
