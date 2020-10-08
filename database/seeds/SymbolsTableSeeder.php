<?php

use Illuminate\Database\Seeder;

class SymbolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $symbols = [
            '無色' => '#999999',
            '赤' => '#ff0000',
            '青' => '#0755ff',
            '赤青' => '',
            '白' => '#c05e84',
            '黒' => '#494790',
            '白黒' => '',
            '緑' => '#448445',
            '紫' => '#9c308d',
            '黃' => '#ff9900',
            '茶' => '#845a1d'
        ];

        foreach ($symbols as $symbolName => $color) {
            DB::table('symbols')->insert([
                'name' => $symbolName,
                'img_path' => null,
                'color_code' => $color,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
