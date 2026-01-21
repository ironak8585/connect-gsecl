<?php

namespace Database\Seeders\Location;

use App\Models\Company\Company;
use App\Models\Location\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get company short named GSECL
        $gseclId = Company::where('slug', 'GSECL')->first()->id;

        $locations = [
            [
                'company_id' => $gseclId,
                'name' => 'Ukai Thermal Power Station',
                'slug' => 'UTPS',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Dhuvaran Thermal Power Station',
                'slug' => 'DTPS',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Wanakbori Thermal Power Station',
                'slug' => 'WTPS',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Gandhinagar Thermal Power Station',
                'slug' => 'GTPS',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Utran Gas Based Power Station',
                'slug' => 'UGPS',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'GSECL Head Office',
                'slug' => 'GSECLHO',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Sikka Thermal Power Station',
                'slug' => 'STPS',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Kutch Lignite Power Station',
                'slug' => 'KLTPS',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Surendranagar Pumping Station',
                'slug' => 'SPS',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Sardar Sarovar Hydro Electric Project',
                'slug' => 'SSHEP',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Kadana Hydro Power Station',
                'slug' => 'KHPS',
            ],
            [
                'company_id' => $gseclId,
                'name' => 'Bhavnagar Lignite Thermal Power Station',
                'slug' => 'BLTPS',
            ],
        ];

        foreach ($locations as $location) {
            //
            Location::firstOrCreate($location);
        }
    }
}
