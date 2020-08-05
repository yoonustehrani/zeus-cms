<?php

use App\User;
use Illuminate\Database\Seeder;
use Zeus\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'admin';
        $user->email = 'admin@zeuspanel.com';
        $user->password = bcrypt('admin1234');
        $user->save();
        $user->roles()->sync(Role::whereName('admin')->first()->id);
    }
}
