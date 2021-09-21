<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    return view('welcome');
})->middleware('setapplanglocal');

Route::get('/send-mail', function () {
   
    $details = [
        'title' => 'Mail from abcd.com 12',
        'body' => 'This is for email using smtp'
    ];
    // return new \App\Mail\MytestMail($details);
    Mail::to('rahul.patil@concettolabs.com')->send(new \App\Mail\MytestMail($details));
   
    dd("Email is Sent.");

});


Auth::routes();

Route::prefix('/{any?}/admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'index'])->name('login');
    Route::get('/register', [App\Http\Controllers\Admin\LoginController::class, 'index'])->name('register');
    
    Route::group(['middleware'=>['auth','checkadminlogin','setapplanglocal']], function () {
        
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
        Route::post('/profile_validation', [App\Http\Controllers\Admin\ProfileController::class, 'profile_validation'])->name('profile_validation');
        
        Route::post('/product/table', [App\Http\Controllers\Admin\ProductController::class, 'tablejson'])->name('product.table');
        Route::get('/product/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('product.delete');
        Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
        // Route::get('/product/index', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('product.index');
        // Route::get('/product/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('product.edit');
        // Route::get('/product/show/{id}', [App\Http\Controllers\Admin\ProductController::class, 'show'])->name('product.show');
        // Route::delete('/product/destroy/{id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('product.destroy');
    });
});
   


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('checkuserlogin');

Route::get('/user/list', [App\Http\Controllers\UserController::class, 'index'])->name('users_list');
Route::get('/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user_edit');
Route::post('/user/save', [App\Http\Controllers\UserController::class, 'save'])->name('user_save');

Route::get('/products/list', [App\Http\Controllers\ProductController::class, 'index'])->name('products.list');
Route::get('/products/add', [App\Http\Controllers\ProductController::class, 'add'])->name('products.add');
Route::post('/products/save', [App\Http\Controllers\ProductController::class, 'save'])->name('products.save');
Route::get('/products/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/save_update/{id}', [App\Http\Controllers\ProductController::class, 'save_update'])->name('products.update');
Route::delete('/products/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete_data'])->name('products.delete');
