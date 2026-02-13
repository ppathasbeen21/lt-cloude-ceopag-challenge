<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $developers = Developer::factory(10)->create();

        $articles = Article::factory(20)->create();

        $articles->each(function ($article) use ($developers) {
            $article->developers()->attach(
                $developers->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        User::factory()->create([
            'name' => 'Patrick',
            'email' => 'pats@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
