<?php

use App\Models\Reply;
use App\Models\Thread;
use App\Models\Channel;
use App\Models\Activity;
use App\Models\Favorite;
use App\Models\ThreadSubscription;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $this->channels()->content();

        Schema::enableForeignKeyConstraints();
    }

    /**
     *
     */
    protected function channels()
    {
        Channel::truncate();

        factory(Channel::class, 10)->create();

        return $this;
    }

    /**
     *
     */
    protected function content()
    {
        Thread::truncate();
        Reply::truncate();
        ThreadSubscription::truncate();
        Activity::truncate();
        Favorite::truncate();

        factory(Thread::class, 50)->create();
    }
}
