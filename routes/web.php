<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'App\Http\Controllers\FunkoController@index')->name('funkos.index');
Route::get('/funkos/create', 'App\Http\Controllers\FunkoController@create')->name('funkos.create')->middleware('admin');
Route::get('/funkos/{funko}', 'App\Http\Controllers\FunkoController@show')->name('funkos.show');
Route::post('/funkos', 'App\Http\Controllers\FunkoController@store')->name('funkos.store')->middleware('admin');
Route::get('/funkos/{funko}/edit', 'App\Http\Controllers\FunkoController@edit')->name('funkos.edit')->middleware('admin');
Route::get('/funkos/{funko}/image', 'App\Http\Controllers\FunkoController@showUpdateImage')->name('funkos.image')->middleware('admin');
Route::post('/funkos/{funko}/image', 'App\Http\Controllers\FunkoController@doUpdateImage')->name('funkos.update-image')->middleware('admin');
Route::put('/funkos/{funko}', 'App\Http\Controllers\FunkoController@update')->name('funkos.update')->middleware('admin');
Route::delete('/funkos/{funko}/delete', 'App\Http\Controllers\FunkoController@destroy')->name('funkos.destroy')->middleware('admin');


Route::prefix('/categories')
    ->group(function () {
        Route::get('/', 'App\Http\Controllers\CategoryController@index')->name('categories.index')->middleware('admin');
        Route::get('/create', 'App\Http\Controllers\CategoryController@create')->name('categories.create')->middleware('admin');
        Route::post('/create', 'App\Http\Controllers\CategoryController@store')->name('categories.store')->middleware('admin');
        Route::get('/{category}/edit', 'App\Http\Controllers\CategoryController@edit')->name('categories.edit')->middleware('admin');
        Route::put('/{category}', 'App\Http\Controllers\CategoryController@update')->name('categories.update')->middleware('admin');
        Route::get('/{category}/toggle-active', 'App\Http\Controllers\CategoryController@toggleActive')->name('categories.toggle-active')->middleware('admin');
        Route::delete('/{category}', 'App\Http\Controllers\CategoryController@destroy')->name('categories.destroy')->middleware('admin');
    })
    ->middleware('admin');


require __DIR__ . '/auth.php';
