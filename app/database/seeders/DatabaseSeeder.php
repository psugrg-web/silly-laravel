<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'test@example.com',
        ]);

        // In most cases you can just implement functionality within this file
        // Job::factory(200)->create();

        // If your application gets bigger you may want to migrate to using separate seeders
        // that you integrate with this class
        $this->call(JobSeeder::class);
    }
}
