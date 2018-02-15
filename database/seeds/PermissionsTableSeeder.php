<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'Administer Roles & Permissions']);
        Permission::create(['name' => 'Edit Collection']);
        Permission::create(['name' => 'View Collection']);

        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Editor']);
        Role::create(['name' => 'Viewer']);

        $role = Role::where('name', '=', 'Admin')->first();
        $role->givePermissionTo('Administer Roles & Permissions', 'Edit Collection', 'View Collection');

        $role = Role::where('name', '=', 'Editor')->first();
        $role->givePermissionTo('Edit Collection', 'View Collection');

        $role = Role::where('name', '=', 'Viewer')->first();
        $role->givePermissionTo('View Collection');

        $user = User::Create(['name' => 'Admin', 'email' => 'test@test.com', 'password' => 'BingoBongo42']);
        $user->assignRole('Admin');
    }
}
