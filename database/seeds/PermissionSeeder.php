<?php

use Illuminate\Database\Seeder;
use Zeus\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission_keys = ['browse_', 'edit_', 'delete_', 'add_', 'read_'];
        $permissions = [
            'admin' => [0],
            'database' => [0,1],
            'menus' => [0,1,2,3],
            'roles' => [0,2,3,4],
            'users' => [0,1,2,3,4],
            'settings' => [0,1,2,3,4]
        ];
        foreach ($permissions as $table => $perms) {
            $skips = ['admin', 'database'];
            foreach ($perms as $key) {
                $permission = [
                    'key' => $permission_keys[$key] . $table,
                    'table_name' => (! in_array($table, $skips)) ? $table : null,
                ];
                Permission::craete($permission);
            }
        }
    }
}
