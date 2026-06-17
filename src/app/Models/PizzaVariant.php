<?php

namespace App\Models;

use App\Models\PizzaOptions\OptionCrust;
use App\Models\PizzaOptions\OptionDough;
use App\Models\PizzaOptions\OptionSize;
use Illuminate\Database\Eloquent\Model;

class PizzaVariant extends Model
{
    protected $fillable = ['pizza_id', 'option_size_id', 'option_dough_id', 'option_crust_id', 'price', 'weight'];

    public function size()
    {
        return $this->belongsTo(OptionSize::class);
    }

    public function dough()
    {
        return $this->belongsTo(OptionDough::class);
    }

    public function crust()
    {
        return $this->belongsTo(OptionCrust::class);
    }
}
