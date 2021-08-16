<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
 * Autors Endpoints
 */
Route::middleware('auth:api')->resource('autors', App\Http\Controllers\Api\AutorController::class)->names('api.autors');

/*
 * Livros Endpoints
 */
Route::middleware('auth:api')->resource('livros', App\Http\Controllers\Api\LivroController::class)->names('api.livros');

/*
 * Generos Endpoints
 */
Route::middleware('auth:api')->resource('generos', App\Http\Controllers\Api\GeneroController::class)->names('api.generos');

/*
 * Editoras Endpoints
 */
Route::middleware('auth:api')->resource('editoras', App\Http\Controllers\Api\EditoraController::class)->names('api.editoras');
