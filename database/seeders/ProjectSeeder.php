<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Technology;
use App\Models\Project;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $category_ids = Category::all()->pluck('id')->all(); // [1,2,3,4,5,6]

        //recupero techonologies per poterle usare
        $technology_ids = Technology::all()->pluck('id')->all();

        for ($i=0; $i < 40; $i++) {

            $project = new Project();
            $project->title = $faker->sentence( $faker->numberBetween(3,5) );
            $project->client = $faker->name;
            $project->description = $faker->optional()->text(100);
            $project->slug = Str::slug($project->title, '-');
            $project->category_id = $faker->optional()->randomElement($category_ids);

            $project->save();

            //recupero la relazione che ci restutisce retunr this->belongsTomany(Techonology::class)
            //quindi un'istanza di una classe
            //randomizzo l'elenco di tecnologie
            $project->technologies()->attach($faker->randomElements($technology_ids, rand(0, 10) ) );


            //CORRETTO RIPOPOLAMENTO DEL DB MYADMIN!!!!!!!!!!!!!
            //1 php artisan migrate:refresh
            //2 php artisan db:seed
        }
    }
}
