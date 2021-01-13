<?php

namespace Zeus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use App\MenuItem;

class MenuBuilderController extends Controller
{
    public function index()
    {

    }
    public function edit(Menu $menu)
    {
        return view('ZEV::pages.menus.builder', compact('menu'));
    }
    public function show($menu)
    {
        $menu = Menu::with(['parent_items' => function($q) {
            $q->orderBy('order', 'asc')->with('children');
        }])->findOrFail($menu);
        
        return $menu;
    }
    public function store(Request $request, Menu $menu)
    {
        $menuItem = new MenuItem();
        $menuItem->title = $request->title;
        $menuItem->url   = $request->url ?: '';
        $menuItem->route   = $request->route;
        $menuItem->icon_class   = $request->icon_class;
        $menuItem->parameters   = json_decode(json_encode($request->parameters));
        $menuItem->order   = $menu->generate_order();
        $menuItem = $menu->items()->create($menuItem->toArray());
        $menuItem->children = [];
        return $menuItem;
    }
    public function update(Request $request, Menu $menu, $menuItem)
    {
        $menuItem = $menu->items()->findOrFail($menuItem);
        $menuItem->title = $request->title;
        $menuItem->url   = $request->url ?: '';
        $menuItem->route   = $request->route;
        $menuItem->icon_class   = $request->icon_class;
        $menuItem->parameters   = json_decode(json_encode($request->parameters));
        if ($menuItem->save()) {
            $menuItem->children = [];
            return $menuItem;
        }
        return response()->json(['error' => [
            [
                'message' => 'Error while updating'
            ]
        ]], 422);
    }
    public function destroy(Menu $menu, $menuItem)
    {
        $menuItem = $menu->items()->findOrFail($menuItem);
        $target_order = $menuItem->order;
        try {
            \DB::beginTransaction();
            if ($menuItem->delete()) {
                $items = $menu->parent_items()->orderBy('order', 'asc')->where('order', '>', (int) $target_order)->get();
                $changed_items = $items->map(function($item) {
                    $item->order -= 1;
                    return $item;
                });
                $menu->items()->saveMany($changed_items);
                \DB::commit();
                return ['okay' => true, 'order' => $target_order];
            }
        } catch(\Exception $e) {
            \DB::rollback();
            throw $e;
        }
    }
    public function updateMany(Request $request, Menu $menu)
    {
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
