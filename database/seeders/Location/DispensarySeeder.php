<?php

namespace Database\Seeders\Location;

use App\Models\Company\Company;
use App\Models\Location\Dispensary;
use App\Models\Location\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DispensarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get company short named GSECL
        $dispensaries = [
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'UTPS',
                'name' => 'Ukai Thermal Power Station Dispensary',
                'address' => 'Ukai Thermal Power Station Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'DTPS',
                'name' => 'Dhuvaran Thermal Power Station Dispensary',
                'address' => 'Dhuvaran Thermal Power Station Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'WTPS',
                'name' => 'Wanakbori Thermal Power Station Dispensary',
                'address' => 'Wanakbori Thermal Power Station Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'GTPS',
                'name' => 'Gandhinagar Thermal Power Station Dispensary',
                'address' => 'Gandhinagar Thermal Power Station Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'UGPS',
                'name' => 'Utran Gas Based Power Station Dispensary',
                'address' => 'Utran Gas Based Power Station Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'GSECLHO',
                'name' => 'GSECL Head Office',
                'address' => 'GSECL HO Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'STPS',
                'name' => 'Sikka Thermal Power Station Dispensary',
                'address' => 'Sikka Thermal Power Station Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'KLTPS',
                'name' => 'Kutch Lignite Power Station Dispensary',
                'address' => 'Kutch Lignite Power Station Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'SPS',
                'name' => 'Surendranagar Pumping Station',
                'address' => 'Surendranagar Pumping Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'SSHEP',
                'name' => 'Sardar Sarovar Hydro Electric Project',
                'address' => 'Sardar Sarovar Hydro Electric Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'KHPS',
                'name' => 'Kadana Hydro Power Station Dispensary',
                'address' => 'Kadana Hydro Power Station Dispensary',
            ],
            [
                'company_slug' => 'GSECL',
                'location_slug' => 'BLTPS',
                'name' => 'Bhavnagar Lignite Thermal Power Station Dispensary',
                'address' => 'Bhavnagar Lignite Thermal Power Station Dispensary',
            ],
        ];

        foreach ($dispensaries as $dispensary) {
            //
            $companyId = Company::where('slug', $dispensary['company_slug'])->first()->id;

            $locationId = Location::where('company_id', $companyId)->where('slug', $dispensary['location_slug'])->first()->id;

            Dispensary::firstOrCreate([
                'name' => $dispensary['name'],
                'address' => $dispensary['address'],
                'company_id' => $companyId,
                'location_id' => $locationId
            ]);
        }
    }
}
