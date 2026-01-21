<?php

namespace Database\Seeders\Admin;

use App\Models\Company\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::firstOrCreate([
            'name' => 'Super Admin User',
            'employee_number' => 99999,
            'company_id' => Company::where('slug', 'gsecl')->first()->id,
            'email' => 'sa@email.com',
            'password' => 'simple123',
            'validate_through_eUrja' => 0,
            'is_active' => 1,
            'status' => 'ACTIVE',
            'last_eUrja_synced_at' => now(),
        ]);

        $user->assignRole('SUPER_ADMIN');
    }
}