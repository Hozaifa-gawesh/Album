<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\AlbumController;
use App\Http\Controllers\Front\PictureController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Albums Route
 Route::controller(AlbumController::class)->as('albums.')->group(function () {
     Route::get('/', 'index')->name('index');
     Route::post('select-album', 'albums')->name('select');
     Route::get('create', 'create')->name('create');
     Route::post('store', 'store')->name('store');
     Route::get('{album_id}/edit', 'edit')->name('edit')->whereNumber('album_id');
     Route::post('{album_id}/update', 'update')->name('update')->whereNumber('album_id');
     Route::post('delete', 'delete')->name('delete');
     Route::post('move', 'move')->name('move');
 });

// Pictures Route
 Route::controller(PictureController::class)->as('pictures.')->prefix('pictures')->group(function () {
     Route::get('{album_id}', 'index')->name('index')->whereNumber('album_id');
     Route::get('{album_id}/create', 'create')->name('create')->whereNumber('album_id');
     Route::post('{album_id}/store', 'store')->name('store')->whereNumber('album_id');
     Route::post('delete', 'delete')->name('delete');
 });
