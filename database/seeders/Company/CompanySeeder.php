<?php

namespace Database\Seeders\Company;

use App\Models\Company\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $companies = [
            [
                'name' => 'Gujarat State Electricity Corporation Limited',
                'slug' => 'GSECL'
            ],
            [
                'name' => 'Gujarat Urja Vikash Nigam Limited',
                'slug' => 'GUVNL'
            ],
            [
                'name' => 'Gujarat Energy Transmission Corporation Limited',
                'slug' => 'GETCO'
            ],
            [
                'name' => 'Madhya Gujarat Vij Company Limited',
                'slug' => 'MGVCL'
            ],
            [
                'name' => 'Uttar Gujarat Vij Company Limited',
                'slug' => 'UGVCL'
            ],
            [
                'name' => 'Dakshin Gujarat Vij Company Limited',
                'slug' => 'DGVCL'
            ],
            [
                'name' => 'Paschim Gujarat Vij Company Limited',
                'slug' => 'PGVCL'
            ],
            [
                'name' => 'Green Energy Transition Research Institute',
                'slug' => 'GETRI'
            ],

        ];

        foreach ($companies as $company) {
            //
            Company::add($company);
        }
    }
}
