<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromTimeString($date)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromTimeString($date)->format('Y-m-d H:i');
    }
}
