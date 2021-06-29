<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Blog\CategoryController;
use App\Http\Controllers\Admin\Blog\PostController as AdminPostController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Blog\PostController;
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

//domains split
Route::domain('laravel-playground.local')
    ->middleware(['middleware' => 'auth'])
    ->get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
Route::domain('admin.laravel-playground.local')
    ->middleware(['middleware' => 'auth.admin'])
    ->get('/', [App\Http\Controllers\HomeController::class, 'adminIndex'])
    ->name('admin.home');

//web part
Route::group([
    'domain' => 'laravel-playground.local',
    'prefix' => 'blog'
], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::resource('/posts', PostController::class)->names('blog.posts');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login-post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register-post');
});

//admin part
Route::group([
    'domain' => 'admin.laravel-playground.local',
    'prefix' => '/blog',
], function () {
    Route::group(['middleware' => ['auth.admin']], function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        $methods = ['index', 'create', 'store', 'edit', 'update'];
        Route::resource('categories', CategoryController::class)
            ->only($methods)
            ->names('admin.blog.categories');
        Route::resource('posts', AdminPostController::class)
            ->except('show')
            ->names('admin.blog.posts');
        Route::match(['patch', 'put'], '/posts/ajax/{post}', [AdminPostController::class, 'updateAjax'])
            ->name('admin.blog.posts.updateAjax');
        Route::patch('/posts/restore/{post}', [AdminPostController::class, 'restore'])
            ->name('admin.blog.posts.restore');
    });

    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login-post');
});

