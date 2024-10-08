<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\District;
use App\Models\LocalBody;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name' => 'Province 1',
                'districts' => [
                    'Morang' => [
                        'Biratnagar Metropolitan City' => ['ward_count' => 19],
                        'Sundarharaicha Municipality' => ['ward_count' => 12],
                        'Belbari Municipality' => ['ward_count' => 11],
                        'Letang Municipality' => ['ward_count' => 9],
                        'Pathari Shanishchare Municipality' => ['ward_count' => 10],
                        'Rangeli Municipality' => ['ward_count' => 9],
                        'Ratuwamai Municipality' => ['ward_count' => 10],
                        'Urlabari Municipality' => ['ward_count' => 9],
                        'Sunawarshi Municipality' => ['ward_count' => 9],
                        'Jahada Rural Municipality' => ['ward_count' => 7],
                        'Budhiganga Rural Municipality' => ['ward_count' => 7],
                        'Katahari Rural Municipality' => ['ward_count' => 7],
                        'Dhanpalthan Rural Municipality' => ['ward_count' => 7],
                        'Kanepokhari Rural Municipality' => ['ward_count' => 7],
                        'Gramthan Rural Municipality' => ['ward_count' => 7],
                        'Kerabari Rural Municipality' => ['ward_count' => 10],
                        'Miklajung Rural Municipality' => ['ward_count' => 9],
                    ],
                    'Sunsari' => [
                        'Itahari Sub-Metropolitan City' => ['ward_count' => 20],
                        'Dharan Sub-Metropolitan City' => ['ward_count' => 20],
                        'Inaruwa Municipality' => ['ward_count' => 10],
                        'Duhabi Municipality' => ['ward_count' => 12],
                        'Ramdhuni Municipality' => ['ward_count' => 9],
                        'Barah Municipality' => ['ward_count' => 11],
                        'Koshi Rural Municipality' => ['ward_count' => 8],
                        'Gadhi Rural Municipality' => ['ward_count' => 6],
                        'Barju Rural Municipality' => ['ward_count' => 6],
                        'Bhokraha Narsingh Rural Municipality' => ['ward_count' => 8],
                        'Harinagar Rural Municipality' => ['ward_count' => 7],
                        'Dewanganj Rural Municipality' => ['ward_count' => 7],
                    ],
                ],
            ],
            [
                'name' => 'Madhesh Province',
                'districts' => [
                    'Saptari' => [
                        'Rajbiraj Municipality' => ['ward_count' => 16],
                        'Kanchanrup Municipality' => ['ward_count' => 12],
                        'Dakneshwori Municipality' => ['ward_count' => 10],
                        'Bodebarsain Municipality' => ['ward_count' => 10],
                        'Khadak Municipality' => ['ward_count' => 11],
                        'Shambhunath Municipality' => ['ward_count' => 12],
                        'Surunga Municipality' => ['ward_count' => 11],
                        'Hanumannagar Kankalini Municipality' => ['ward_count' => 14],
                        'Saptakoshi Rural Municipality' => ['ward_count' => 11],
                        'Agnisair Krishna Savaran Rural Municipality' => ['ward_count' => 6],
                        'Rupani Rural Municipality' => ['ward_count' => 6],
                        'Balan-Bihul Rural Municipality' => ['ward_count' => 6],
                        'Bishnupur Rural Municipality' => ['ward_count' => 7],
                        'Rajgadh Rural Municipality' => ['ward_count' => 6],
                        'Mahadeva Rural Municipality' => ['ward_count' => 6],
                        'Tirahut Rural Municipality' => ['ward_count' => 5],
                        'Tilathi Koiladi Rural Municipality' => ['ward_count' => 8],
                        'Chhinnamasta Rural Municipality' => ['ward_count' => 7],
                    ],
                    'Siraha' => [
                        'Lahan Municipality' => ['ward_count' => 24],
                        'Dhangadhimai Municipality' => ['ward_count' => 14],
                        'Siraha Municipality' => ['ward_count' => 22],
                        'Golbazar Municipality' => ['ward_count' => 13],
                        'Mirchaiya Municipality' => ['ward_count' => 12],
                        'Kalyanpur Municipality' => ['ward_count' => 12],
                        'Karjanha Municipality' => ['ward_count' => 11],
                        'Sukhipur Municipality' => ['ward_count' => 10],
                        'Bhagwanpur Rural Municipality' => ['ward_count' => 5],
                        'Aurahi Rural Municipality' => ['ward_count' => 5],
                        'Bishnupur Rural Municipality' => ['ward_count' => 5],
                        'Bariyarpatti Rural Municipality' => ['ward_count' => 5],
                        'Lakshmipur Patari Rural Municipality' => ['ward_count' => 6],
                        'Naraha Rural Municipality' => ['ward_count' => 5],
                        'Sakhuwanankarkatti Rural Municipality' => ['ward_count' => 5],
                        'Arnama Rural Municipality' => ['ward_count' => 5],
                        'Navarajpur Rural Municipality' => ['ward_count' => 5],
                    ],
                ],
            ],
        ];

        foreach ($datas as $stateData) {
            $state = State::create([
                'name' => $stateData['name'],
            ]);

            foreach ($stateData['districts'] as $districtName => $localBodies) {
                $district = District::create([
                    'name' => $districtName,
                    'state_id' => $state->id,
                ]);

                foreach ($localBodies as $localBodyName => $details) {
                    LocalBody::create([
                        'name' => $localBodyName,
                        'ward_count' => $details['ward_count'],
                        'state_id' => $state->id,
                        'district_id' => $district->id,
                    ]);
                }
            }
        }
    }
}
