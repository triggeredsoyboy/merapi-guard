<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProneAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prone_areas')->insert([
            [
                'name' => 'Kawasan Rawan Bencana I',
                'slug' => 'krb-i',
                'description' => 'Kawasan Rawan Bencana I adalah kawasan yang berpotensi terlanda lahar/banjir dan tidak menutup kemungkinan dapat terkena perluasan awan panas dan aliran lava.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kawasan Rawan Bencana II',
                'slug' => 'krb-ii',
                'description' => 'Kawasan Rawan Bencana II adalah kawasan yang berpotensi terlanda aliran massa berupa awan panas, aliran lava dan lahar, serta lontaran berupa material jatuhan dan lontaran batu (pijar).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kawasan Rawan Bencana III',
                'slug' => 'krb-iii',
                'description' => 'Kawasan Rawan Bencana III adalah kawasan yang letaknya dekat dengan sumber bahaya yang sering terlanda awan panas, aliran lava, guguran batu, lontaran batu (pijar) dan hujan abu lebat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
