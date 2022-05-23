<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'firstname',
        'lastname',
        'phone',
        'picture',
        'wallet_address',
        '2FA',
        'description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function apiClient()
    {
        return $this->hasOne(ApiClient::class);
    }

    public function purchases()
    {
        return $this->hasMany();
    }

    public function batches()
    {
        return $this->belongsToMany(Batch::class)->withPivot('quantity')->with('item');
    }

    public function fiame_orders()
    {
        return FiameOrder::where ('user_id',$this->id)->get();
    }
}
