<?php

use App\Http\Controllers\Blog\Auth\RegisterController;
use App\Http\Controllers\Blog\Admin\Auth\LoginController;
use App\Http\Controllers\Blog\Auth\LoginController as CustomerLoginController;
use App\Http\Controllers\Blog\Admin\CategoryController;
use App\Http\Controllers\Blog\Admin\PostController as AdminPostController;
use App\Http\Controllers\Blog\PostController;
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
    Route::domain('laravel-playground.local')
        ->middleware(['middleware' => 'auth'])
        ->get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::domain('admin.laravel-playground.local')
        ->middleware(['middleware' => 'auth.admin'])
        ->get('/', [App\Http\Controllers\HomeController::class, 'adminIndex']);

Route::group([
    'domain' => 'laravel-playground.local',
    'prefix' => 'blog'
], function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('/posts', PostController::class)->names('blog.posts');
        Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('logout');
    });

    Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomerLoginController::class, 'login'])->name('login-post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register-post');
});

Route::group([
    'domain' => 'admin.laravel-playground.local',
    'prefix' => '/blog',
], function () {
    Route::group(['middleware' => ['auth.admin']], function () {
        Route::get('/', [App\Http\Controllers\HomeController::class, 'adminIndex'])->name('admin.home');
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

        $methods = ['index', 'create', 'store', 'edit', 'update'];
        Route::resource('categories', CategoryController::class)
            ->only($methods)
            ->names('blog.admin.categories');
        Route::resource('posts', AdminPostController::class)
            ->except('show')
            ->names('blog.admin.posts');
        Route::put('/posts/{post}',[AdminPostController::class, 'updateAjax'])->name('blog.admin.posts.updateAjax');
    });

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login-post');
});

