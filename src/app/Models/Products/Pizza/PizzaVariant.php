<?php

namespace App\Models\Products\Pizza;

use Illuminate\Database\Eloquent\Model;

class PizzaVariant extends Model
{
    protected $fillable = ['pizza_id', 'option_size_id', 'option_dough_id', 'option_crust_id', 'price', 'weight'];
}
