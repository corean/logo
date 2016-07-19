<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            [ 'name' => 'logo', 'email' => 'logo@corean.biz', 'password' => bcrypt('2341') ],
            [ 'name' => 'corean', 'email' => 'corean@corean.biz', 'password' => bcrypt('2341') ]
        ]);

        factory(App\User::class, 50)
            ->create()
            ->each(function($u) {
                $u->boards()->save(factory(App\Board::class)->make());
            });
    }
}
