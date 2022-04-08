<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'accounts'
    ];

    public function crimes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Crime::class, 'crime_character');
    }

    public function investigations(){
        return $this->belongsToMany(Investigation::class, 'character_investigation');
    }

    public function licenses(){
        return $this->hasMany(UserLicense::class);
    }

    public function wanted(){
        return $this->hasMany(Wanted::class);
    }
}
