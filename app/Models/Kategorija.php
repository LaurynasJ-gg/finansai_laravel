<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
    protected $fillable = [
        'pavadinimas',
        'tipas'
    ];

    protected $table = 'kategorijos';

    public function finansai()
    {
        return $this->hasMany(Finansai::class);
    }
}
