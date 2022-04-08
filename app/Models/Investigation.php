<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function suspects(){
        return $this->belongsToMany(Character::class, 'character_investigation');
    }

    public function comments()
    {
        return $this->hasMany(InvestigationComment::class);
    }

    public function getCreatedAtAttribute($date): string
    {
        return Carbon::createFromTimeString($date)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date): string
    {
        return Carbon::createFromTimeString($date)->format('Y-m-d H:i');
    }
}
