<?php

namespace App\Models\Products\Pizza\Options;

use App\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class OptionSize extends Model
{
    use BaseOption;
    use Sluggable;
}
