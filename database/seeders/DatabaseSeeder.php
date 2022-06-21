<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Je crée 5 catégories
        $categories = Category::factory()->count(5)->create();

        // Je crée 10 films et attache aléatoirement une catégorie à chaque film
        Film::factory()->count(10)->make()
            ->each(function($film) use ($categories) {
                $film->category_id = $categories->random()->id;
                $film->save();
            });
    }
}
