<?php

use App\Http\Controllers\Api\AdminApiController;
use App\Http\Controllers\Api\WebApiController;
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

Route::name('blog.')
    ->domain(config('app.url'))
    ->prefix('/blog')
    ->group(function () {

        Route::match(['patch', 'put'], '/posts/like/{post}', [WebApiController::class, 'toggleLike'])
            ->name('posts.like');
    });

Route::name('admin.blog.')
    ->domain('admin.' . config('app.url'))
    ->prefix('/blog')
    ->group(function () {
        Route::group(['middleware' => 'auth:admin'], function () {
            Route::match(['patch', 'put'], '/comments/{comment}', [AdminApiController::class, 'togglePublishComment'])
                ->name('comments.ajax');
            Route::match(['patch', 'put'], '/posts/{post}', [AdminApiController::class, 'togglePublishPost'])
                ->name('posts.ajax');
        });
    });
