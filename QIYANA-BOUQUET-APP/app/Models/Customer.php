<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Customer extends Authenticatable
{
    //
    use HasFactory;

    protected $fillable = [
        'full_name', 'email', 'phone', 'address', 'password',
    ];

    protected $hidden = ['password'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
