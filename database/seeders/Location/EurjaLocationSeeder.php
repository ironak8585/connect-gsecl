<?php

namespace Database\Seeders\Location;

use App\Models\Company\Company;
use App\Models\Location\EurjaLocation;
use App\Models\Location\Location;
use Illuminate\Database\Seeder;

class EurjaLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eUrjaLocations = [
            [
                'code' => '90020000',
                'name' => 'Ukai Thermal Power Station',
                'slug' => 'UTPS',
                'master' => '90020000:Ukai Thermal Power Station'
            ],
            [
                'code' => '90060000',
                'name' => 'Dhuvaran Thermal Power Station',
                'slug' => 'DTPS',
                'master' => '90060000:Dhuvaran Thermal Power Station'
            ],
            [
                'code' => '90040000',
                'name' => 'Wanakbori Thermal Power Station',
                'slug' => 'WTPS',
                'master' => '90040000:Wanakbori Thermal Power Station'
            ],
            [
                'code' => '90010000',
                'name' => 'Gandhinagar Thermal Power Station',
                'slug' => 'GTPS',
                'master' => '90010000:Gandhinagar Thermal Power Station'
            ],
            [
                'code' => '90050000',
                'name' => 'Utran Gas Based Power Station',
                'slug' => 'UGPS',
                'master' => '90050000:Utran Gas Based Power Station'
            ],
            [
                'code' => '90000000',
                'name' => 'GSECL Head Office',
                'slug' => 'GSECLHO',
                'master' => '90000000:GSECL Head Office'
            ],
            [
                'code' => '90070000',
                'name' => 'Sikka Thermal Power Station',
                'slug' => 'STPS',
                'master' => '90070000:Sikka Thermal Power Station'
            ],
            [
                'code' => '90090000',
                'name' => 'Kutch Lignite Power Station',
                'slug' => 'KLTPS',
                'master' => '90090000:Kutch Lignite Power Station'
            ],
            [
                'code' => '90110000',
                'name' => 'Surendranagar Pumping Station',
                'slug' => 'SPS',
                'master' => '90110000:SURENDRANAGAR PUMPING STATION'
            ],
            [
                'code' => '90030000',
                'name' => 'Ukai Hydro Power Station',
                'slug' => 'UTPS',
                'master' => '90030000:Ukai Hydro Power Station'
            ],
            [
                'code' => '90100000',
                'name' => 'Sardar Sarovar Hydro Electric Project',
                'slug' => 'SSHEP',
                'master' => '90100000:SARDAR SAROVAR HYDRO ELECTRIC PROJECT'
            ],
            [
                'code' => '90080000',
                'name' => 'Kadana Hydro Power Station',
                'slug' => 'KHPS',
                'master' => '90080000:Kadana Hydro Power Station'
            ],
            [
                'code' => '90010005',
                'name' => 'GTPS Unit 5',
                'slug' => 'GTPS',
                'master' => '90010005:GTPS Unit 5'
            ],
            [
                'code' => '90120000',
                'name' => 'Bhavnagar Lignite Thermal Power Station',
                'slug' => 'BLTPS',
                'master' => '90120000: BHAVNAGAR LIGNITE THERMAL POWER STATION'
            ],
            [
                'code' => '9005000030',
                'name' => 'UGPS:CCPP-II(Operation)',
                'slug' => 'UGPS',
                'master' => '9005000030:UGPS:CCPP-II(Operation)'
            ],
            [
                'code' => '9005000034',
                'name' => 'UGPS:CCPP-II(Instrument)',
                'slug' => 'UGPS',
                'master' => '9005000034:UGPS:CCPP-II(Instrument)'
            ],

        ];

        foreach ($eUrjaLocations as $eUrjaLocation) {
            $location = Location::where('slug', $eUrjaLocation['slug'])->first();

            if (!$location) {
                dd("Location not found for slug: " . $eUrjaLocation['slug']);
            }

            $eUrjaLocation['location_id'] = $location->id;
            unset($eUrjaLocation['slug']);

            EurjaLocation::firstOrCreate($eUrjaLocation);
        }
    }
}
