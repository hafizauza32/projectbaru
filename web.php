<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TransaksiController::class, 'index'])->name('home');
Route::post('/addTocart', [TransaksiController::class, 'addTocart'])->name('addTocart');
Route::get('/shope', [Controller::class, 'shope'])->name('shope');
Route::get('/transaksi', [Controller::class, 'transaksi'])->name('transaksi');
Route::get('/contact', [Controller::class, 'contact'])->name('contact');
Route::get('/checkout', [Controller::class, 'checkout'])->name('checkout');




Route::get('/admin', [Controller::class, 'login'])->name('login');
Route::POST('/admin/loginProses', [Controller::class, 'loginProses'])->name('loginProses');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/dashboard', [Controller::class, 'admin'])->name('admin');
    Route::get('/admin/product', [ProductController::class, 'index'])->name('product');
    Route::get('/admin/logout', [Controller::class, 'logout'])->name('logout');
    Route::get('/admin/report', [Controller::class, 'report'])->name('report');
    Route::get('/admin/addModal', [ProductController::class, 'addModal'])->name('addModal');

    Route::post('/admin/addData', [ProductController::class, 'store'])->name('addData');
    Route::get('/admin/editModal/{id}', [ProductController::class, 'show'])->name('editModal');
    Route::put('/admin/updateData/{id}', [ProductController::class, 'update'])->name('updateData');
    Route::delete('/admin/deleteData/{id}', [ProductController::class, 'destroy'])->name('deleteData');

    Route::get('/admin/user_management', [UserController::class, 'index'])->name('userManagement');
    Route::get('/admin/user_management/addModalUser', [UserController::class, 'addModalUser'])->name('addModalUser');
    Route::post('/admin/user_management/addData', [UserController::class, 'store'])->name('addDataUser');
    Route::get('/admin/user_management/editUser/{id}', [UserController::class, 'show'])->name('showDataUser');
    Route::put('/admin/user_management/updateDataUser/{id}', [UserController::class, 'update'])->name('updateDataUser');
    Route::delete('/admin/user_management/deleteUser/{id}', [UserController::class, 'destroy'])->name('destroyDataUser');
});
