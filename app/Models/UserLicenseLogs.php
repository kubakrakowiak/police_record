<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLicenseLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'log_type',
        'type',
        'owner',
        'digit',
        'grade',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
