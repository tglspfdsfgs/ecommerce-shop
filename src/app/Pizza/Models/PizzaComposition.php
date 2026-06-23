<?php

namespace App\Pizza\Models;

use Illuminate\Database\Eloquent\Model;

class PizzaComposition extends Model
{
    protected $fillable = ['ingredient_id', 'pizza_id', 'quantity'];
}
