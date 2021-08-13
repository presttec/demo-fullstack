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
 * Authors Endpoints
 */
Route::middleware('auth:api')->resource('authors', App\Http\Controllers\Api\AuthorController::class)->names('api.authors');

/*
 * Books Endpoints
 */
Route::middleware('auth:api')->resource('books', App\Http\Controllers\Api\BooksController::class)->names('api.books');

/*
 * Genders Endpoints
 */
Route::middleware('auth:api')->resource('genders', App\Http\Controllers\Api\GenderController::class)->names('api.genders');

/*
 * Authors Endpoints
 */
Route::middleware('auth:api')->resource('authors', App\Http\Controllers\Api\AuthorController::class)->names('api.authors');

/*
 * Books Endpoints
 */
Route::middleware('auth:api')->resource('books', App\Http\Controllers\Api\BooksController::class)->names('api.books');

/*
 * Genders Endpoints
 */
Route::middleware('auth:api')->resource('genders', App\Http\Controllers\Api\GenderController::class)->names('api.genders');

/*
 * Authors Endpoints
 */
Route::middleware('auth:api')->resource('authors', App\Http\Controllers\Api\AuthorController::class)->names('api.authors');

/*
 * Books Endpoints
 */
Route::middleware('auth:api')->resource('books', App\Http\Controllers\Api\BooksController::class)->names('api.books');

/*
 * Genders Endpoints
 */
Route::middleware('auth:api')->resource('genders', App\Http\Controllers\Api\GenderController::class)->names('api.genders');
