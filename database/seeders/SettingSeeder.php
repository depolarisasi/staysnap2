<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([

            'key' => 'site_title',

            'value' => 'StaySnap', 

        ]);

        DB::table('settings')->insert([

            'key' => 'site_logo',

            'value' => '#', 

        ]);
    }
}
