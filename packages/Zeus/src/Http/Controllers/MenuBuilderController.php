<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;

class MenuBuilderController extends Controller
{
    public function index()
    {

    }
    public function edit(Menu $menu)
    {
        return view('ZEV::pages.menus.builder', compact('menu'));
    }
    public function items(Menu $menu)
    {
        $menu->load('parent_items.children');
        return $menu;
    }
    public function update(Request $request, Menu $menu) {
        $menu->load('parent_items.children');
        $items = $request->items;
        foreach ($items as $item) {
            
        }
    }
}
