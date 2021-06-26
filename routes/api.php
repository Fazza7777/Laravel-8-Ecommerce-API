<?php


use Illuminate\Support\Facades\Route;

Route::post('/login','Admin\ApiController@login');
Route::post('/register','Admin\ApiController@register');

Route::get('/categories','Admin\ApiController@categories');
Route::get('/subcat/{id}','Admin\ApiController@subCategories');

Route::group(['middleware'=>'jwt.auth',"namespace"=>"Admin"],function(){
    Route::get('/me','ApiController@me');
});
