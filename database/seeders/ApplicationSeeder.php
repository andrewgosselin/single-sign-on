<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app = \App\Models\Application::create([
            "name" => "Portfolio",
            "url" => "https://cyrexag.com"
        ]);
    }
}
