<?php

namespace Database\Seeders;

use App\Models\FiameOrder;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RandomizeOrders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (FiameOrder::all() as $order) {
            $order->paid = (rand(1,10) > 3 ? 1 : 0 );
            $order->created_at = Carbon::today()->subDay(rand(0,50));
            $order->save();
        }
    }
}
