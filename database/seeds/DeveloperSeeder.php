<?php


use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminTablesSeeder::class);
        $this->call(ProductsSeeder::class);
    }
}
