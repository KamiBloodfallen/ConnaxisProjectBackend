<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interes extends Model
{
    use HasFactory;
    protected $table = 'interes';
    protected $forenKey = "IdUsu";
    protected $fillable = [
        'Familia', 'Deportes', 'Comida', 'Turismo', 'Baile', 'Fitness',
    ];
}
