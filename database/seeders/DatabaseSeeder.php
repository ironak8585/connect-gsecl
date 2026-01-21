<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\Admin\EurjaDepartmentSeeder;
use Database\Seeders\Admin\PermissionSeeder;
use Database\Seeders\Admin\RoleHasPermissionsSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\UserSeeder;
use Database\Seeders\Company\CompanySeeder;
use Database\Seeders\Location\EurjaLocationSeeder;
use Database\Seeders\Location\LocationDepartmentSeeder;
use Database\Seeders\Master\CircularCategorySeeder;
use Database\Seeders\Master\CoreDepartmentSeeder;
use Database\Seeders\Master\SubDepartmentSeeder;
use Database\Seeders\Location\DepartmentSeeder;
use Database\Seeders\Location\LocationSeeder;
use Database\Seeders\Master\DesignationSeeder;
use Database\Seeders\Master\QualificationSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Seeders
        $this->call(PermissionSeeder::class); // To load the default permissions
        $this->call(RoleSeeder::class);
        $this->call(RoleHasPermissionsSeeder::class);

        // Master Seeders
        $this->call(CompanySeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(EurjaLocationSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(QualificationSeeder::class);
        $this->call(CircularCategorySeeder::class);

        // Department Seeders
        $this->call(EurjaDepartmentSeeder::class);
        $this->call(CoreDepartmentSeeder::class);
        $this->call(SubDepartmentSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(LocationDepartmentSeeder::class);

        $this->call(UserSeeder::class);
    }
}
