<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'United States' => [
                'iso' => 'US',
                'states' => [
                    'California' => ['Los Angeles', 'San Francisco', 'San Diego', 'Sacramento'],
                    'Texas' => ['Houston', 'Dallas', 'Austin', 'San Antonio'],
                    'New York' => ['New York City', 'Buffalo', 'Rochester'],
                    'Florida' => ['Miami', 'Orlando', 'Tampa', 'Jacksonville'],
                    'Illinois' => ['Chicago', 'Springfield'],
                    'Arizona' => ['Phoenix', 'Tucson', 'Mesa'],
                    'Georgia' => ['Atlanta', 'Savannah'],
                    'Washington' => ['Seattle', 'Spokane'],
                    'Nevada' => ['Las Vegas', 'Reno'],
                ],
            ],
            'Canada' => [
                'iso' => 'CA',
                'states' => [
                    'Ontario' => ['Toronto', 'Ottawa', 'Mississauga', 'Hamilton'],
                    'Quebec' => ['Montreal', 'Quebec City', 'Laval'],
                    'British Columbia' => ['Vancouver', 'Victoria', 'Surrey'],
                    'Alberta' => ['Calgary', 'Edmonton', 'Red Deer'],
                    'Manitoba' => ['Winnipeg', 'Brandon'],
                    'Saskatchewan' => ['Regina', 'Saskatoon'],
                    'Nova Scotia' => ['Halifax', 'Sydney'],
                    'New Brunswick' => ['Moncton', 'Saint John'],
                ],
            ],
        ];

        foreach ($locations as $countryName => $data) {
            $country = Country::firstOrCreate(['name' => $countryName], ['iso_code' => $data['iso']]);

            foreach ($data['states'] as $stateName => $cities) {
                $state = State::firstOrCreate(['country_id' => $country->id, 'name' => $stateName]);

                foreach ($cities as $cityName) {
                    City::firstOrCreate(['state_id' => $state->id, 'name' => $cityName]);
                }
            }
        }
    }
}