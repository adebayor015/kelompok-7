<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin KRFSM',
            'email' => 'admin@krfsm.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'bio' => 'Administrator KRFSM',
        ]);

        // Create Sample Users
        User::create([
            'name' => 'Reza',
            'email' => 'reza@krfsm.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'bio' => 'Pelajar SMA kelas 10',
        ]);

        User::create([
            'name' => 'Kukuh',
            'email' => 'kukuh@krfsm.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'bio' => 'Pelajar SMA kelas 11',
        ]);

        User::create([
            'name' => 'Farel',
            'email' => 'farel@krfsm.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'bio' => 'Pelajar SMA kelas 12',
        ]);

        // Create Sample Topics via TopicSeeder
        $this->call([
            TopicSeeder::class,
        ]);
    }
}
