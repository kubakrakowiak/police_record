<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jail extends Model
{
    use HasFactory;

    protected $table = 'jail';

    public $timestamps = false;

    protected $fillable = [
        'identifier',
        'digit',
        'jail_time',
        'timeleft',
        'executed'
    ];
}
