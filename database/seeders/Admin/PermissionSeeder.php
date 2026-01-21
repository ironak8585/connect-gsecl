<?php

namespace Database\Seeders\Admin;

use Artisan;
use Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Artisan::call("cache:clear");
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = Config::get("permissions");

        $data = [];
        foreach ($permissions as $permission) {

            $data = [
                "name" => $permission[0],
                "guard_name" => $permission[1],
                "description" => $permission[2],
            ];

            Permission::firstOrCreate($data);
        }
    }
}
