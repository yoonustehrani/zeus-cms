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
    public function show(Menu $menu)
    {
        $menu->load('parent_items.children');
        return $menu;
    }
    public function update(Request $request, Menu $menu) {
        $menu->load('items');
        $items = $request->items;
        $updateIds = array_keys($items);
        $changed_items = collect([]);
        foreach ($menu->items as $item) {
            if (in_array($item->id, $updateIds)) {
                foreach ($items[$item->id] as $key => $value) {
                    $item->{$key} = $value;
                }
                $changed_items->push($item);
            }
        }
        $menu->items()->saveMany($changed_items);
        return ['okay' => true];
    }
}
