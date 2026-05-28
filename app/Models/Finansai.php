<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finansai extends Model
{
    protected $fillable = [
        'user_id', 
        'tipas',
        'kategorija_id',
        'suma',
        'data',
        'aprasymas'
    ];

    public function kategorija()
    {
        return $this->belongsTo(Kategorija::class);
    }   
}
