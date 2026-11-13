<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    private const TAGS = ['Purok Ancog', 'Urgent', 'Libre', 'Schedule', 'Ayuda'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = collect(self::TAGS)->map(fn (string $name) => Tag::create(['name' => $name]));

        // 1–3 random tags per post, written to post_tag through the relationship.
        Post::all()->each(function (Post $post) use ($tags): void {
            $post->tags()->attach($tags->random(random_int(1, 3))->pluck('id'));
        });

        // sync() replaces whatever was attached above, so the pinned post
        // always ends up with exactly these two tags.
        $pinned = Post::where('is_pinned', true)->firstOrFail();
        $pinned->tags()->sync(
            $tags->whereIn('name', ['Purok Ancog', 'Urgent'])->pluck('id')
        );
    }
}
