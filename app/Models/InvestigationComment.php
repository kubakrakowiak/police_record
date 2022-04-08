<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestigationComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'user_id',
        'investigation_id',
    ];

    public function investigation()
    {
        return $this->belongsTo(Investigation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromTimeString($date)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromTimeString($date)->format('Y-m-d H:i:s');
    }
}
