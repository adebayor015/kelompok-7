<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Biologi',
            'Fisika',
            'Kimia',
            'Sejarah',
            'PPKN',
            'Agama',
        ];

        foreach ($topics as $name) {
            Topic::updateOrCreate([
                'slug' => \Illuminate\Support\Str::slug($name)
            ], [
                'name' => $name,
            ]);
        }
    }
}
