<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Blog\CategoryController;
use App\Http\Controllers\Admin\Blog\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\Blog\TagController;
use App\Http\Controllers\Admin\Blog\PostController as AdminPostController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Blog\CommentController;
use App\Http\Controllers\Web\Blog\PostController;
use App\Http\Controllers\Web\Blog\ProfileController;
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
    ->middleware('auth')
    ->get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
Route::domain('admin.laravel-playground.local')
    ->middleware('auth:admin')
    ->get('/', [App\Http\Controllers\HomeController::class, 'adminIndex'])
    ->name('admin.home');

//web part
Route::name('blog.')
    ->domain('laravel-playground.local')
    ->prefix('/blog')
    ->group(function () {
        Route::group(['middleware' => ['guest']], function () {
            Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [LoginController::class, 'login'])->name('login-post');
            Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
            Route::post('/register', [RegisterController::class, 'register'])->name('register-post');
        });

        Route::delete('/logout', [LoginController::class, 'logout'])
            ->name('logout')
            ->middleware('auth');

        Route::group(['middleware' => ['auth', 'email']], function () {

            //posts resource
            Route::resource('/posts', PostController::class)
                ->names('posts');

            //comments
            Route::match(['delete'], '/comments/delete/{comment}', [CommentController::class, 'destroy'])
                ->name('comments.delete');
            Route::match(['post'], '/comments/store', [CommentController::class, 'store'])
                ->name('comments.store');

            //profile
            Route::resource('/profile', ProfileController::class)->names('profile')
                ->only(['show', 'edit', 'update']);

            //email confirmation
            Route::get('/{user}/confirm-email', [RegisterController::class, 'confirmEmail'])
                ->name('confirm.email')
                ->middleware('signed')
                ->withoutMiddleware('email');

            Route::get('/{user}/confirmation-page', [ProfileController::class, 'emailConfirmPage'])
                ->name('profile.confirmation-page')
                ->withoutMiddleware('email');

            //follow-unfollow user
            Route::post('/profile/follow/{user}', [ProfileController::class, 'follow'])
                ->name('profile.follow');
            Route::delete('/profile/unfollow/{user}', [ProfileController::class, 'unfollow'])
                ->name('profile.unfollow');

            // api:
            //notifications
            Route::get('/notifications', [ProfileController::class, 'notifications'])
                ->name('notifications')
                ->withoutMiddleware('email');

            Route::patch('/notifications/mark-as-read', [ProfileController::class, 'markAsReadAllNotifications'])
                ->name('notifications.read');

            //like-dislike
            Route::match(['patch', 'put'], '/posts/like/{post}', [PostController::class, 'like'])
                ->name('posts.like');
        });
    });

//admin part
Route::name('admin.blog.')
    ->domain('admin.laravel-playground.local')
    ->prefix('/blog')
    ->group(function () {
        Route::group(['middleware' => 'auth:admin'], function () {
            Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
            Route::resource('categories', CategoryController::class)
                ->except('show')
                ->names('categories');
            Route::resource('posts', AdminPostController::class)
                ->except('show')
                ->names('posts');
            Route::resource('comments', AdminCommentController::class)
                ->except(['show', 'create'])
                ->names('comments');
            Route::resource('tags', TagController::class)
                ->only(['create', 'store', 'index', 'edit', 'update', 'destroy'])
                ->names('tags');
            Route::match(['patch', 'put'], '/comments/ajax/{comment}', [AdminCommentController::class, 'ajax'])
                ->name('comments.ajax');
            Route::match(['patch', 'put'], '/posts/ajax/{post}', [AdminPostController::class, 'ajax'])
                ->name('posts.ajax');
            Route::patch('/posts/restore/{post}', [AdminPostController::class, 'restore'])
                ->name('posts.restore');
        });

        Route::group(['middleware' => ['guest']], function () {
            Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
            Route::post('/login', [AdminLoginController::class, 'login'])->name('login-post');
        });
    });

