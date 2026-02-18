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

        $developers = Developer::factory(10)->create();

        $articles = Article::factory(20)->create([
            'category_id' => fn() => $categories->random()->id
        ]);

        $articles->each(function ($article) use ($developers) {
            $article->developers()->attach(
                $developers->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        User::factory()->create([
            'name' => 'Patrick',
            'email' => 'pats@ceopag.com',
            'password' => Hash::make('password'),
        ]);
    }
}
