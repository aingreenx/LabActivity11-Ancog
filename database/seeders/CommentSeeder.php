<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        // 0–5 comments by random users on every published post except the pinned one.
        Post::where('is_published', true)
            ->where('is_pinned', false)
            ->get()
            ->each(function (Post $post) use ($users): void {
                Comment::factory()
                    ->count(random_int(0, 5))
                    ->for($post)
                    ->sequence(fn () => ['user_id' => $users->random()->id])
                    ->create();
            });

        $pinned = Post::where('is_pinned', true)->firstOrFail();
        $lola = User::where('email', 'lola.ancog@bulletin.test')->firstOrFail();
        $kagawad = User::where('email', 'kagawad.ancog@bulletin.test')->firstOrFail();
        $resident = $users->whereNotIn('id', [$lola->id, $kagawad->id])->random();

        // Created through the relation, so post_id is filled in automatically.
        $pinned->comments()->createMany([
            ['user_id' => $lola->id, 'body' => 'I will bring extra walis tingting for the young ones. See you all at the hall!'],
            ['user_id' => $resident->id, 'body' => 'Our family will join. What time does the clean-up start?'],
            ['user_id' => $kagawad->id, 'body' => 'Assembly is at 6:00 AM. Salamat sa tanan nga moapil!'],
        ]);
    }
}
