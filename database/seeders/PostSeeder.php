<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = Author::all();

        Post::factory()->count(40)
            ->sequence(fn ($seq) => ['author_id' => $authors->random()->id])
            ->create();

        Post::factory()->count(10)->draft()
            ->sequence(fn ($seq) => ['author_id' => $authors->random()->id])
            ->create();

        $kagawad = Author::where('email', 'kagawad.ancog@bulletin.test')->firstOrFail();

        Post::create([
            'author_id' => $kagawad->id,
            'title' => 'Purok Ancog Clean-up Drive',
            'category' => 'Announcement',
            'body' => 'All residents of Purok Ancog are invited to join the clean-up drive. Please bring your own gloves and walis tingting. Assembly is at the Barangay Matina Crossing Hall.',
            'is_published' => true,
            'is_pinned' => true,
            'published_at' => '2026-06-17',
        ]);
    }
}
