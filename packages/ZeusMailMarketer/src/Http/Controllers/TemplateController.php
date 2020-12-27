<?php

namespace ZeusMailMarketer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZeusMailMarketer\Models\Template;

class TemplateController extends Controller {
    const route_prefix = "RomanCamp.extention.zeus-mail-marketer.templates.";
    public function index()
    {
        $templates = Template::select('name')->withCount('campaigns')->get();
        return $templates;
    }
    public function create()
    {
        return view('ZEMMV::pages.templates.create');
    }
    public function store(Request $request)
    {
        $template = new Template();
        $template->name = $request->name;
        $template->content = $request->content;
        $template->save();
        return redirect()->to(route(self::route_prefix . "index"));
    }
}