<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;
    protected $table ="gendre";
    protected $fillable = [
        'statusenabled', 'genre_name'
    ];
}
