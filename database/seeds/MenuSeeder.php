<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = new Menu;
        $menu->name = 'admin';
        $menu->display_name = 'Admin';
        $menu->save();
        $items = [
            [
                'route' => 'RomanCamp.dashboard',
                'title' => 'Dashboard',
                'icon_class' => 'fas fa-home',
                'parameters' => null,
            ],
            [
                'route' => 'RomanCamp.database.index',
                'title' => 'Database',
                'icon_class' => 'fas fa-database',
                'parameters' => null,
            ]
        ];
        foreach ($items as $i => $item) {
            $item['order'] = $i;
            // $item['updated_at'] = now();
            $menu->items()->create($item);
        }
    }
}
