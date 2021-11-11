<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebService extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "user_id",
        "token",
    ];
    protected $casts = [
        "token"=>"json"
    ];
}
