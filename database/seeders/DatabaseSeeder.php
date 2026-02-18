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
        $user = User::create([
            'name' => 'Patrick',
            'email' => 'patrick@ceopag.com',
            'password' => Hash::make('password'),
        ]);

        $categories = collect([
            'Notícias',
            'Novidades',
            'Infraestrutura',
            'Desenvolvimento',
            'DevOps',
            'Cloud Computing'
        ])->map(fn($name) => Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]));

        $developers = Developer::factory(6)->create([
            'user_id' => $user->id,
        ]);

        $articles = Article::factory(10)->create([
            'user_id' => $user->id,
            'category_id' => fn() => $categories->random()->id,
        ]);

        $articles->each(function ($article) use ($developers) {
            $article->developers()->attach(
                $developers->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}
