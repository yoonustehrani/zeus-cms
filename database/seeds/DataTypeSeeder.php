<?php

use Illuminate\Database\Seeder;
use Zeus\Models\DataType;

class DataTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataTypesArray = [
            ['user','fas fa-user','App\\User','Zeus\\Http\\Controllers\\UserController'],
            ['menu','fas fa-bars','App\\Menu','Zeus\\Http\\Controllers\\MenuController'],
            ['roles','fas fa-user-tag','App\\Role','Zeus\\Http\\Controllers\\RoleController'],
        ];
        foreach ($dataTypesArray as $i => $dt) {
            $dataType = [
                'name' => "{$dt[0]}s",
                'slug' => "{$dt[0]}s",
                'display_name_singular' => ucfirst($dt[0]),
                'display_name_plural' => ucfirst($dt[0]) . 's',
                'icon' => $dt[1],
                'model_name' => $dt[2],
                'policy_name' => '',
                'controller' => $dt[3],
                'description' => '',
                'details' => null,
                'generate_permission' => true,
                'server_side' => true
            ];
            DataType::create($dataType);
        }

    }
}
