<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Duty extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'start_duty',
        'end_duty',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

}
