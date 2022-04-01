<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        $users = User::factory(2)->create();
        $categories = Category::factory(5)->create();

        for($i = 0; $i < 30; $i++){
            Post::factory()->create([
                'user_id' => $users[rand(0,1)]->id,
                'category_id' => $categories[rand(0,4)]->id
            ]);
        }

    }
}
