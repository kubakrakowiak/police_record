<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'created_by',
        'type',
        'closed_at',
    ];

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'investigation_users');
    }
}
