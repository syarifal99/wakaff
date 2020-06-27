<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'      => 'Superadmin',
            'username'  => 'superadmin',
            'email'     => 'superadmin@tes.com',
            'password'  => Hash::make('password'),
        ]);
            
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'mitra']);

        $roleSuperadmin = Role::create(['name' => 'superadmin']);

        $user->assignRole($roleSuperadmin);
    }
}
