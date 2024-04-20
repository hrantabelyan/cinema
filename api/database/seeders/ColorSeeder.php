<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            [
                'slug' => 'red',
                'title' => 'Red'
            ],
            [
                'slug' => 'blue',
                'title' => 'Blue'
            ],
            [
                'slug' => 'green',
                'title' => 'Green'
            ],
            [
                'slug' => 'yellow',
                'title' => 'Yellow'
            ],
            [
                'slug' => 'orange',
                'title' => 'Orange'
            ],
            [
                'slug' => 'purple',
                'title' => 'Purple'
            ],
            [
                'slug' => 'black',
                'title' => 'Black'
            ],
            [
                'slug' => 'white',
                'title' => 'White'
            ],
            [
                'slug' => 'gray',
                'title' => 'Gray'
            ],
            [
                'slug' => 'pink',
                'title' => 'Pink'
            ],
        ];

        $currentDatetime = now();

        foreach ($colors as $color) {
            $existingColor = DB::table('colors')->where('slug', $color['slug'])->exists();

            if (!$existingColor) {
                DB::table('colors')->insert([
                    'slug' => $color['slug'],
                    'title' => $color['title'],
                    'created_at' => $currentDatetime,
                    'updated_at' => $currentDatetime,
                ]);
            }
        }
    }
}
