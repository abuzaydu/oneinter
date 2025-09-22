<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Shabani Mtaita',
            'phone' => '0762560460',
            'email' => 'admin@oneintertravel.com',
            'password' => bcrypt('Admin123'),
            'default_pass' => 'Admin123',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        $role = new Role();
        $role->name = 'admin';
        $role->description = 'Full access to all features';
        $role->save();

        $permissions = Permission::all();
        foreach ($permissions as $key => $value) {
            $role->givePermissionTo($value);
        }

        $user->assignRole($role);
    }
}
