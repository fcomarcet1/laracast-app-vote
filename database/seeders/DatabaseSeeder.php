<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Idea;
use App\Models\User;
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
        User::factory(5)->create();
        Category::factory()->create(['name' => 'category 1']);
        Category::factory()->create(['name' => 'category 2']);
        Category::factory()->create(['name' => 'category 3']);
        Category::factory()->create(['name' => 'category 4']);
        //category::factory(10)->create();
        Idea::factory(25)->create();
    }
}
