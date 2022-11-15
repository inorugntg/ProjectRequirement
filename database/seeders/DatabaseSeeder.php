<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UserSeeder::class,
            JobSeeder::class,
            SkillSeeder::class,
            PenggunaSeeder::class,
        ]);
    
        // DB:table('pengguna')->insert([
        //     'nama' => 'ahmes',
        //     'birth_year' => '2006',
        //     'email' => 'ikiahmes@gmail.com',
        //     'phone' => '08994580101',
        //     'job' => 'FrontEnd Engineer',
        //     'skill'=> 'React JS',
        // ]);
    }
}
