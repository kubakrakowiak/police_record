<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrol extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'patrol_user');
    }

    public function car(){
        return $this->belongsTo(Car::class);
    }
}
