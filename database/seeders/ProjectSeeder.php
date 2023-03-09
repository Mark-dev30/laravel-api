<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//RICHIAMO IL GENERATORE FAKER PER GENERARE TESTI, DATE ECC RANDOM
use Faker\Generator as Faker;
//RICHIAMO Str CHE SVOLGE LA FUNZIONE DI CONVERTIRE IL TITLE IN SLUG
use Illuminate\Support\Str;
//RICHIAMO IL MODEL
use App\Models\Project;


class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $newProject = new Project();
            $newProject->title = $faker->sentence(3);
            $newProject->description = $faker->text(300);
            $newProject->date = $faker->date();
            $newProject->slug = Str::slug($newProject->title, '-');
            $newProject->save();
        }
    }
}
