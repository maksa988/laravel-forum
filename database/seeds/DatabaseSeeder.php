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
        // $this->call(UsersTableSeeder::class);

        $threads = factory(\App\Models\Thread::class, 50)->create();

        $threads->each(function ($thread) {
            factory(\App\Models\Reply::class, 10)->create(['thread_id' => $thread->id]);
        });
    }
}
