<?php

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

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', 'AuthController@dashboard');

//Route::get('/change-card-number', function () {
//    return view('change-card-number');
//});

Route::get('/dashboard', 'AuthController@dashboard')->name('user.dashboard');

Route::get('/login', 'AuthController@index')->name('login');

Route::post('/custom-login', 'AuthController@customLogin')->name('login.custom');

Route::get('/registration', 'AuthController@registration')->name('register-user');

Route::post('/custom-registration', 'AuthController@customRegistration')->name('register.custom');
Route::get('/change-card-number', 'UserController@ChangeCardNumber')->name('change.card.number');
Route::post('/change-card-number-action', 'UserController@ChangeCardNumberUser')->name('change-card-number-action');

Route::get('/signout', 'AuthController@signOut')->name('signout');

Route::get('/products', 'ProductsController@products')->name('products');
Route::view('/productsList', 'products');

Route::get('/product/{id}', 'ProductsController@product')->name('product');

Route::post('/payment/{id}', 'PaymentController@Payment')->name('payment.buy');
Route::get('/payment_api', 'PaymentController@PaymentApi')->name('payment.api');
Route::post('/payment-callback', 'PaymentController@PaymentCallback')->name('payment.payment-callback');
