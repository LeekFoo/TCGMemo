<?php

use Illuminate\Database\Seeder;

class RaritysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $raritys = ['HR', 'SR+', 'R+', 'SR', 'R', 'HN', 'N', 'PR'];

        foreach ($raritys as $rarity) {
            DB::table('raritys')->insert([
                'name' => $rarity,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
