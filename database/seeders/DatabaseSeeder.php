<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Developer;
use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $patrick = User::create([
            'name' => 'Patrick',
            'email' => 'pats@ceopag.com',
            'password' => Hash::make('password'),
        ]);

        $otherUsers = User::factory(2)->create();

        $allUsers = $otherUsers->prepend($patrick);

        $categories = collect([
            'Notícias',
            'Novidades',
            'Infraestrutura',
            'Desenvolvimento',
            'DevOps',
            'Cloud Computing'
        ])->map(function ($name) {
            return Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        });

        $allUsers->each(function ($user) use ($categories) {
            $developers = Developer::factory(rand(3, 6))->create([
                'user_id' => $user->id,
            ]);

            $articles = Article::factory(rand(3, 8))->create([
                'user_id' => $user->id,
                'category_id' => fn() => $categories->random()->id,
            ]);

            $articles->each(function ($article) use ($developers) {
                $article->developers()->attach(
                    $developers->random(rand(1, 3))->pluck('id')->toArray()
                );
            });
        });
    }
}
