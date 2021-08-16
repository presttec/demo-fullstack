<?php

use Illuminate\Support\Facades\Route;

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

Route::permanentRedirect('/', '/login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
 * Autors Routes
 */
Route::resource('autores', App\Http\Controllers\AutorController::class);

/*
 * Livros Routes
 */
Route::resource('livros', App\Http\Controllers\LivroController::class);

/*
 * Generos Routes
 */
Route::resource('generos', App\Http\Controllers\GeneroController::class);

/*
 * Editoras Routes
 */
Route::resource('editoras', App\Http\Controllers\EditoraController::class);
