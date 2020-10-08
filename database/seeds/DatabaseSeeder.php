<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(FoldersTableSeeder::class);
        $this->call(TitlesTableSeeder::class);
        $this->call(RaritysTableSeeder::class);
        $this->call(SymbolsTableSeeder::class);
    }
}
