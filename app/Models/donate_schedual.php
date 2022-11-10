<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class donate_schedual extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        "user_id",
        "amount",
        "blood_type_id",
        "verified"
    ];

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function blood_type()
    {
        return $this->belongsTo(BloodType::class,"blood_type_id");
    }
    public function log()
    {
        return $this->belongsToMany(User::class, 'log');
    }
}
