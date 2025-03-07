<?php

namespace Database\Seeders;

use App\Models\Announcement;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);


        // call factory  
        $this->call(NewsSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(AlumniSeeder::class);
        $this->call(KerjasamaSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(AboutSeeder::class);
        $this->call(ExtrakulikulerSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(MapelSeeder::class);
        $this->call(WaktuSeeder::class);
    }
}
