<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            'name'=>fake()->name(),
            'body'=>fake()->text(),
            'user_id'=>fake()->numberBetween(1,5),
            'categoria_id'=>fake()->numberBetween(1,5)
        ]);
    }
}
