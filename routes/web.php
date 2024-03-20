<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;
use Spatie\LaravelIgnition\FlareMiddleware\AddJobs;

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

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

//login, register
Route::middleware(['admin_auth'])->group(function () {
    Route::redirect('/', 'loginPage');
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {
    //dashboard
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    //admin middleware
    Route::middleware(['admin_auth'])->group(function () {
        //category
        Route::prefix('category')->group(function () {
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('create/page', [CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create', [CategoryController::class, 'create'])->name('category#create');
            Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
            Route::post('update', [CategoryController::class, 'update'])->name('category#update');
        });

        //products
        Route::prefix('products')->group(function () {
            Route::get('list', [ProductController::class, 'list'])->name('products#list');
            Route::get('create/page', [ProductController::class, 'createPage'])->name('products#createPage');
            Route::post('create', [ProductController::class, 'create'])->name('products#create');
            Route::get('delete/{id}', [ProductController::class, 'delete'])->name('products#delete');
            Route::get('edit/{id}', [ProductController::class, 'edit'])->name('products#edit');
            Route::get('updatePage/{id}', [ProductController::class, 'updatePage'])->name('products#updatePage');
            Route::post('update', [ProductController::class, 'update'])->name('products#update');
        });

        //order
        Route::prefix('order')->group(function () {
            Route::get('list', [OrderController::class, 'orderList'])->name('admin#orderList');
            Route::get('change/status', [OrderController::class, 'changeStatus'])->name('admin#changeStatus');
            Route::get('ajax/change/status', [OrderController::class, 'ajaxChangeStatus'])->name('admin#ajaxChangeStatus');
            Route::get('listInfo/{orderCode}', [OrderController::class, 'listInfo'])->name('admin#listInfo');
        });

        //account
        Route::prefix('account')->group(function () {
            //change password
            Route::get('password/changePasswordPage', [AdminController::class, 'changePasswordPage'])->name('account#changePasswordPage');
            Route::post('password/change', [AdminController::class, 'changePassword'])->name('account#changePassword');

            //account information
            Route::get('details', [AdminController::class, 'details'])->name('account#details');
            Route::get('edit', [AdminController::class, 'edit'])->name('account#edit');
            Route::post('update/{id}', [AdminController::class, 'update'])->name('account#update');
            Route::get('list', [AdminController::class, 'list'])->name('account#list');
            Route::get('delete/{id}', [AdminController::class, 'delete'])->name('account#delete');
            Route::get('changeRole/{id}', [AdminController::class, 'changeRole'])->name('account#changeRole');
            Route::post('change/role/{id}', [AdminController::class, 'change'])->name('account#change');
        });
    });

    //user
    //home
    Route::group(['prefix' => 'user', 'middleware' => 'user_auth'], function () {
        Route::get('homePage', [UserController::class, 'home'])->name('user#home');
        Route::get('homePagebyCat/{id}', [UserController::class, 'homePagebyCat'])->name('user#homePagebyCat');
        Route::get('history', [UserController::class, 'history'])->name('user#history');

        Route::prefix('pizza')->group(function () {
            Route::get('details/{id}', [UserController::class, 'pizzaDetails'])->name('user#pizzaDetails');
        });

        Route::prefix('cart')->group(function () {
            Route::get('list', [UserController::class, 'cartList'])->name('user#cartList');
        });

        Route::group(['prefix' => 'password'], function () {
            Route::get('changePasswordPage', [UserController::class, 'changePasswordPage'])->name('user#changePasswordPage');
            Route::post('changePassword', [UserController::class, 'changePassword'])->name('user#changePassword');
        });

        Route::group(['prefix' => 'account'], function () {
            Route::get('changeAccountPage', [UserController::class, 'changeAccountPage'])->name('user#changeAccountPage');
            Route::post('changeAccount/{id}', [UserController::class, 'changeAccount'])->name('user#changeAccount');
        });

        Route::prefix('ajax')->group(function () {
            Route::get('pizzaList', [AjaxController::class, 'pizzaList'])->name('ajax#pizzaList');
            Route::get('addToCart', [AjaxController::class, 'addToCart'])->name('ajax#addToCart');
            Route::get('order', [AjaxController::class, 'order'])->name('ajax#order');
            Route::get('clearCart', [AjaxController::class, 'clearCart'])->name('ajax#clearCart');
            Route::get('clear/current/product', [AjaxController::class, 'clearCurrentProduct'])->name('ajax#clearCurrentProduct');
            Route::get('increase/viewCount', [AjaxController::class, 'increaseViewCount'])->name('ajax#increaseViewCount');
        });
    });
});
