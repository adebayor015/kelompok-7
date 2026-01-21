<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topiks = [
            ['name' => 'Matematika', 'slug' => 'matematika'],
            ['name' => 'IPA', 'slug' => 'ipa'],
            ['name' => 'Bahasa Inggris', 'slug' => 'bahasa-inggris'],
            ['name' => 'Sejarah', 'slug' => 'sejarah'],
            ['name' => 'PPKN', 'slug' => 'ppkn'],
        ];

        foreach ($topiks as $t) {
            Topic::updateOrCreate(['slug' => $t['slug']], $t);
        }
    }
}