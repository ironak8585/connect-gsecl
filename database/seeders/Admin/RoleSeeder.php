<?php

namespace Database\Seeders\Admin;

use Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add super admin role
        Role::firstOrCreate(["name" => Config::get("constants.admin.USER.ROLES.SUPER_ADMIN")]);

        // Add default role for app
        $roles = Config::get('constants.admin.USER.ROLES');
        foreach ($roles as $name => $desc) {
            Role::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }
    }
}
