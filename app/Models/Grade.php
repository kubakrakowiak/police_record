<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
        'order',
        'name',
        'job_id',
        'abilities'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
