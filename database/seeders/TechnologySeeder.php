<?php

namespace Database\Seeders;

//importo model e Str!!!
use App\Models\Technology;
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $technologies = ['CSS','SASS','Bootstrap', 'HTML','JavaScript','PHP','Vue','SQL','Laravel','Vite'];

        foreach($technologies as $technology_name){
            $technology = new Technology();
            $technology->name = $technology_name;
            $technology->slug = Str::slug($technology_name);
            $technology->save();
        }

    }
}
