<?php


use Illuminate\Support\Facades\Route;


## For Not Auth
Route::group(['namespace'=>'Admin'],function(){

    Route::post('/login','ApiController@login');
    Route::post('/register','ApiController@register');

    Route::get('/categories','ApiController@categories');
    Route::get('/subcat/{id}','ApiController@subCategories');
    Route::get('/tags','ApiController@tags');
    Route::get('/products','ApiController@products');
    Route::get('/productByCat/{id}','ApiController@productByCategory');
    Route::get('/productBySubCat/{id}','ApiController@productBysubCat');
    Route::get('/productByTag/{id}','ApiController@productByTag');
});

## For If Auth

Route::group(['middleware'=>'jwt.auth',"namespace"=>"Admin"],function(){
    Route::get('/me','ApiController@me');
});
