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
    $fullname = "yoonus tehrani";
    $html = file_get_contents(__DIR__ . '/../examples/index.html');
    $content = (new NormalizeTags)
                ->content($html)
                ->tags(['fullname'])
                ->values(compact('fullname'))
                ->normalize();
    // return response($html);
    // $css = "
    // h1 {
    //     color: red;
    // }
    // .dool {
    //     color: blueviolet;
    //     font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    // }
    // ";
    // $css = file_get_contents(__DIR__ . '/examples/sumo/style.css');

    // output
    // $html2 = $cssToInlineStyles->convert(
    //     $html,
    //     $css
    // );
    // return response($content);
    $mailable = new CampaignMailer($content, 'به ال ناول خوش آمدید', ['newsletter@Elnovel.net', 'یونس طهرانی - دپارتمان فروش']);
    try {
        Mail::manual_mailer('yoonus_gmail', [
            'transport' => 'smtp',
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'encryption' => 'tls',
            'username' => 'yoonustehrani28@gmail.com',
            'password' => 'koplsiucclqsfbvn',
            'timeout' => 60,
            'auth_mode' => null,
            'pretend' => false,
            ])
            ->to('elnovelofficial@gmail.com')
            ->send($mailable);
    } catch (\Throwable $th) {
        throw $th;
        return 'error';
    }
    return view('welcome');
});

Route::prefix('zeus')->group(function() {
    Zeus::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

