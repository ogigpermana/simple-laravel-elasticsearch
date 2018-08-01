<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Remove any existing data
      DB::table('articles')->truncate();

      factory(App\Models\Article::class, 50)->create();
    }
}
