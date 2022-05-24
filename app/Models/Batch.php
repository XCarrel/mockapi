<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['id','quantity','paid']); // pivot is the order for the product
    }

    public function item()
    {
        return $this->belongsTo(Item::class)->with('user');
    }

    public function gathering()
    {
        return $this->belongsTo(Gathering::class);
    }

    public function orders()
    {
        return $this->hasMany(FiameOrder::class);
    }
}
