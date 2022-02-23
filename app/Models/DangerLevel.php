<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DangerLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'started_at',
        'ended_at',
        'user_id',
        'type',
    ];

    public function user(){
        $this->belongsTo(User::class, 'user_id');
    }
}
