<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finansai extends Model
{
    protected $fillable = [
        'tipas',
        'kategorija',
        'suma',
        'aprasymas'
    ];
}
