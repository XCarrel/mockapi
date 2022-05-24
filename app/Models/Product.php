<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $table = "items";

    public $timestamps = false;

    protected $with = ['user'];

//    protected $fillable = ['name', 'img', 'selling_date', 'price', 'user_id'];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function batches()
    {
        return $this->hasMany(Batch::class,'item_id');
    }

    public function orders()
    {
        $res = [];
        foreach ($this->batches as $batch) {
            foreach ($batch->orders as $order) {
                $res[] = [
                    'order_id' => $order->id,
                    'product' => $this->title,
                    'placed_by' => $order->user->name,
                    'quantity' => $order->quantity,
                    'paid' => $order->paid,
                    'order_date' => $order->created_at,
                    'event_date' => $batch->gathering->date
                ];
            }
        }
        return $res;
    }
}
