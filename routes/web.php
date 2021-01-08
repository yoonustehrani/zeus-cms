<?php

use App\Mail\CampaignMailer;
use App\Mail\UserSubscribed;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use ZeusMailMarketer\Services\NormalizeTags;

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
    // $cssToInlineStyles = new CssToInlineStyles();
    // $fullname = "yoonus tehrani";
    // $html = file_get_contents(__DIR__ . '/../examples/index.html');
    // $content = (new NormalizeTags)
    //             ->content($html)
    //             ->tags(['fullname'])
    //             ->values(compact('fullname'))
    //             ->normalize();
    // output
    // $content = $cssToInlineStyles->convert($content); // , $css
    // $mailable = (new CampaignMailer($content))->subject('به ال ناول خوش آمدید')->from('newsletter@Elnovel.net', 'یونس طهرانی - دپارتمان فروش');
    // return $mailable;
    // try {
    //     Mail::manual_mailer('yoonus_gmail', [
    //         'transport' => 'smtp',
    //         'host' => 'smtp.gmail.com',
    //         'port' => 587,
    //         'encryption' => 'tls',
    //         'username' => 'yoonustehrani28@gmail.com',
    //         'password' => 'koplsiucclqsfbvn',
    //         'timeout' => 60,
    //         'auth_mode' => null,
    //         'pretend' => false,
    //         ])
    //         ->to('elnovelofficial@gmail.com')
    //         ->send($mailable);
    // } catch (\Throwable $th) {
    //     throw $th;
    //     return 'error';
    // }
    return view('welcome');
});

Route::prefix('zeus')->group(function() {
    Zeus::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

