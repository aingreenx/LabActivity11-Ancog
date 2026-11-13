<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Order matters: users link to an existing author, and tags and comments
     * need posts (and users) to exist first.
     */
    public function run(): void
    {
        $this->call([
            AuthorSeeder::class,
            PostSeeder::class,
            UserSeeder::class,
            TagSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
