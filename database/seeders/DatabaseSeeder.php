<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(['email' => 'admin@library.com'], [
            'name' => 'Admin User',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create regular test user
        $studentUser = User::updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        // Link test account to a student profile for student dashboard access
        Student::updateOrCreate(
            ['student_number' => '20260001'],
            [
                'name' => 'Test User',
                'course' => 'BSIT',
                'email' => 'test@example.com',
                'user_id' => $studentUser->id,
            ]
        );

        // Seed books with cover images
        $this->call([
            BookSeeder::class,
        ]);
    }
}
