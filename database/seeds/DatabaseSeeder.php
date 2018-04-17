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

        $faker = \Faker\Factory::create();
        $statuses = collect([
            "pending",
            "in progress",
            "completed"
        ]);

        for ($i = 0; $i < 25; $i++) {
            \App\Task::create([
                "link"   => $faker->url,
                "status" => $statuses->random(),
                "file_url" => "#"
            ]);
        }
    }
}
