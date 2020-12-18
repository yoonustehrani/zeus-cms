<?php

use App\Mail\UserSubscribed;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

// $mailable = new UserSubscribed();
// $res = Mail::manual_mailer('yoonus_gmail', [
    // 'transport' => 'smtp',
    // 'host' => 'smtp.gmail.com',
    // 'port' => 587,
    // 'encryption' => 'tls',
    // 'username' => 'yoonustehrani28@gmail.com',
    // 'password' => 'koplsiucclqsfbvn',
    // 'timeout' => null,
    // 'auth_mode' => null,
// ])
// ->to('elnovelofficial@gmail.com')
// ->send($mailable);
// dd($res);

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('zeus')->group(function() {
    Zeus::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

