<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackedProduct extends Model
{
    use HasFactory;
     protected $fillable = [
        'url',
        'title',
        'last_price',
        'last_checked_at',
    ];

    public $timestamps = true;
}
