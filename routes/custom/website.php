<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\TagController;
use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\PostController;
use App\Http\Controllers\Website\PlaceController;
use App\Http\Controllers\Website\CatFactController;
use App\Http\Controllers\Website\CommentController;
use App\Http\Controllers\Website\CatBreadController;
use App\Http\Controllers\Website\CategoryController;
use App\Http\Controllers\Website\SpecificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('posts', PostController::class)->except(['store', 'update', 'destroy']);
Route::apiResource('posts.comments', CommentController::class)->except(['show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('specifications', SpecificationController::class)->only(['index', 'show']);
Route::apiResource('tags', TagController::class)->only(['index', 'show']);
Route::apiResource('places', PlaceController::class)->only(['index', 'show']);

//auth routes
Route::post('signin', [AuthController::class, 'signIn']);
Route::post('signup', [AuthController::class, 'signUp']);
Route::post('forget-password', [AuthController::class, 'forgetPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:api'])->group(function(){
    Route::get('signout', [AuthController::class, 'signOut']);
    Route::get('profile', [AuthController::class, 'profile']);
});

Route::get('cat-breeds', [CatBreadController::class, 'index']);
Route::get('cat-facts', [CatFactController::class, 'index']);
