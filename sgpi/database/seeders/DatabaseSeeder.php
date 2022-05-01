<?php

namespace Database\Seeders;

use App\Models\Labs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(LabsSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(MaterialsSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(LoanSeeder::class);
        $this->call(TicketsSeeder::class);
    }
}
