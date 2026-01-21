<?php

namespace Database\Seeders\Admin;

use Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get role has permissions mapping
        $permissions = Config::get("rolepermissions");

        // dd($permissions);

        // permissions with roles
        if (count($permissions) > 0) {
            foreach ($permissions as $role => $permissions) {
                if (count($permissions) > 0) {
                    $role = Role::firstOrCreate([
                        'name' => $role
                    ]);
                    $role->syncPermissions($permissions);
                }
            }
        }
    }
}
