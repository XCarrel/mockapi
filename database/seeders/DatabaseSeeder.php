<?php

namespace Database\Seeders;

use App\Models\ApiClient;
use App\Models\Batch;
use App\Models\Gathering;
use App\Models\Item;
use App\Models\User;
use App\Models\batchuser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(20)->create();
        foreach (User::all() as $user) {
            $ac = new ApiClient();
            $ac->api_token = Str::random(30);
            $ac->user()->associate($user);
            $ac->save();
        }
        $items = Item::factory(10)->create(['user_id' => function() use ($users) {return $users->random()->id;}]);
        $gatherings = Gathering::factory(10)->create(['user_id' => function() use ($users) {return $users->random()->id;}]);
        $batches = Batch::factory(10)->create(['gathering_id' => function() use ($gatherings) {return $gatherings->random()->id;}, 'item_id' => function() use ($items) {return $items->random()->id;}]);
        for ($i=0; $i < 30; $i++) {
            $batch = Batch::all()->random();
            $user = User::all()->random();
            $user->batches()->attach($batch, ['quantity' => rand(1,10)]);
        }
    }
}
