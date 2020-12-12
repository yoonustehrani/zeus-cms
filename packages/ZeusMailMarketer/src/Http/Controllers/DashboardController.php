<?php

namespace ZeusMailMarketer\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('ZEMMV::dashboard');
    }
}