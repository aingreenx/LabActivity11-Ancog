<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Author;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Lola Ancog',
            'email' => 'lola.ancog@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        $kagawad = User::create([
            'name' => 'Kagawad Greece Ancog',
            'email' => 'kagawad.ancog@bulletin.test',
            'password' => Hash::make('bulletin2026'),
        ]);

        // Link the login account to the existing author profile (User hasOne Author).
        // save() through the relation sets authors.user_id for us.
        $profile = Author::where('email', 'kagawad.ancog@bulletin.test')->firstOrFail();
        $kagawad->author()->save($profile);

        User::factory()->count(8)->create();
    }
}
