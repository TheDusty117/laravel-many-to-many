<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Frontend','Backend','Fullstack','Design','Gestionali','Videogiochi'];

        // ciclo array con categorie
        foreach($categories as $category_name) {
            $new_cat = new Category();
            $new_cat->name = $category_name;
            $new_cat->slug = Str::slug($category_name);

            $new_cat->save();
        }


    }
}
