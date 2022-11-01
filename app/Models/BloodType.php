<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'type',


    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function donate()
    {
        return $this->hasMany(donate_schedual::class);
    }
}
