<?php

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
         $this->call(UsersTableSeeder::class);
        // $this->call(SkillTableSeeder::class);
        // \Eloquent::unguard();
        // $this->command->info('User table seeded!');

        // $path = __DIR__ .'/mysql-country-list.sql';
        // DB::unprepared(file_get_contents($path));
        // $this->command->info('Country table seeded!');
       // $this->call(JobCategorySeeder::class);
        //$this->call(PermissionSeeder::class);
    }
}
