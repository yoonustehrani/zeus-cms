<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(PermissionSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(AdminSeeder::class);
        // $this->call(MenuSeeder::class);
        $this->call(DataTypeSeeder::class);
    }
}
