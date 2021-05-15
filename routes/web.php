<?php

use App\Http\Controllers\Blog\Admin\Auth\LoginController;
use App\Http\Controllers\Blog\Admin\Auth\RegisterController;
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

Route::group(['prefix' => 'blog'], function () {
    Route::resource('posts', PostController::class)
        ->names('blog.posts');
});
Route::group(['prefix' => 'admin/blog'], function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login-post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('admin.register-post');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

    $methods = ['index', 'create', 'store', 'edit', 'update'];
    Route::resource('categories', CategoryController::class)
        ->only($methods)
        ->names('blog.admin.categories');
    Route::resource('posts', AdminPostController::class)
        ->only($methods)
        ->names('blog.admin.posts');
});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
