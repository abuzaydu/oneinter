<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = array(
            'view_roles', 
            'create_roles',
            'edit_roles',
            'delete_roles',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_cars', 
            'create_cars', 
            'edit_cars', 
            'delete_cars', 
            'view_bookings', 
            'create_bookings', 
            'edit_bookings', 
            'delete_bookings', 
            'view_drivers', 
            'create_drivers', 
            'edit_drivers', 
            'delete_drivers',
            'view_dashboard',
        );

        foreach ($permissions as $key => $perm) {
            $permission = Permission::where('name', $perm)->first();
            if (is_null($permission)) {
                $permission = new Permission();
                $permission->name = $perm;
                $permission->save();
            }
        }
    }
}
