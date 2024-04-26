<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SpecificationController;

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
// 	return $request->user();
// });

//auth routes
Route::post('signin', [AuthController::class, 'signIn']);
Route::middleware(['auth:api'])->group(function(){
    Route::get('signout', [AuthController::class, 'signOut']);
    Route::get('profile', [AuthController::class, 'profile']);
//end
    Route::apiResource('posts', PostController::class);
    Route::apiResource('posts.comments', CommentController::class)->only(['index', 'update', 'destroy']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('specifications', SpecificationController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('places', PlaceController::class);
});

