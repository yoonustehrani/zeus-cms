<?php

namespace ZeusMailMarketer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;
use ZeusMailMarketer\Models\Template;

class TemplateController extends Controller {
    const route_prefix = "RomanCamp.extention.zeus-mail-marketer.templates.";
    public function index()
    {
        $templates = Template::select(['name', 'id'])->withCount('campaigns')->get();
        return view('ZEMMV::pages.templates.index', compact('templates'));
    }
    public function create()
    {
        return view('ZEMMV::pages.templates.create');
    }
    public function store(Request $request)
    {
        $template = new Template();
        $template->name = $request->name;
        $template->css  = $request->css;
        $template->content = $request->content;
        $template->save();
        return redirect()->to(route(self::route_prefix . "index"));
    }
    public function show($template)
    {
        $template = Template::findOrFail($template);
        $cssToInlineStyles = new CssToInlineStyles();
        $body = $cssToInlineStyles->convert($template->content, $template->css);
        return view('ZEMMV::pages.templates.show', compact('body'));
    }
    public function edit($template)
    {
        $template = Template::select(['name', 'id'])->first();
        return view('ZEMMV::pages.templates.edit', compact('template'));
    }
    public function update(Request $request, $template)
    {
        $template = Template::findOrFail($template);
        $template->name = $request->name;
        $template->css  = $request->css;
        $template->content = $request->content;
        $template->save();
        return redirect()->to(route(self::route_prefix . "edit", ['template' => $template->id]));
    }
    public function showApi($template)
    {
        return Template::findOrFail($template);
    }
}