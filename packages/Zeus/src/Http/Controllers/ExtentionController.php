<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Zeus\Extentions\EmailMarketingSystem;
use Zeus\Models\Extention;
use ZeusMailMarketer\ZeusMailMarketer;

class ExtentionController extends Controller
{
    public function index()
    {
        $extentions = (object) \Zeus::get_extentions();
        return view('ZEV::pages.extentions.index', compact('extentions'));
    }
}