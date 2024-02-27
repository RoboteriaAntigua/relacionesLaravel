<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //	title 	biografia 	website 	user_id 
        DB::table('profiles')->insert([
            'title'=>fake()->title(),
            'biografia'=>fake()->text(),
            'website'=>fake()->name(),
            'user_id'=>fake()->numberBetween(1,20)            //Como es relacion 1 a 1 este hay que ingresarlo a mano porque es unique()
        ]);
    }
}
