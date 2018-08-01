<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // Remove any existing data
      DB::table('users')->truncate();

      factory(App\Models\User::class, 5)->create();
    }
}
