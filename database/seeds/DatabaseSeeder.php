<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schoolyears')->insert([
            'title' => '2017 - 2018',
            'start' => '2017-08-01',
            'end' => '2018-07-31'
        ]);
        DB::table('schoolyears')->insert([
            'title' => '2018 - 2019',
            'start' => '2018-08-01',
            'end' => '2019-07-31'
        ]);

        DB::table('meetings')->insert([
            'schoolyear_id' => '1',
            'year' => 2018,
            'iso_week' => 9,
            'iso_day' => 4,
            'term' => 3,
            'week' => 4
        ]);
        DB::table('meetings')->insert([
            'schoolyear_id' => '1',
            'year' => 2018,
            'iso_week' => 10,
            'iso_day' => 4,
            'term' => 3,
            'week' => 5
        ]);
        DB::table('meetings')->insert([
            'schoolyear_id' => '1',
            'year' => 2018,
            'iso_week' => 11,
            'iso_day' => 4,
            'term' => 3,
            'week' => 6
        ]);
    }
}
