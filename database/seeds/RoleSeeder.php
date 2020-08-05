<?php

use Illuminate\Database\Seeder;
use Zeus\Models\Permission;
use Zeus\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['admin' => '*'];
        $permissions = Permission::all();
        foreach ($roles as $rolename => $perms) {
            if ($perms == '*') {
                $role = new Role;
                $role->title = ucfirst($rolename);
                $role->name  = $rolename;
                $role->save();
                foreach ($permissions as $permission) {
                    $role->permissions()->attach($permission->id);
                }
            }
        }
    }
}
