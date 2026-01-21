<?php

namespace Database\Seeders\Master;

use App\Models\Master\CircularCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CircularCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Circulars related to human resources policies and updates.',
                'is_active' => true,
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Circulars related to financial matters and announcements.',
                'is_active' => true,
            ],
            [
                'name' => 'Safety',
                'code' => 'SAF',
                'description' => 'Circulars related to safety protocols and guidelines.',
                'is_active' => true,
            ],
            [
                'name' => 'IT Announcements',
                'code' => 'IT',
                'description' => 'Circulars related to IT updates and information.',
                'is_active' => true,
            ],
            [
                'name' => 'General Notices',
                'code' => 'GEN',
                'description' => 'General circulars for all employees.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            CircularCategory::add($category);
        }
    }
}
