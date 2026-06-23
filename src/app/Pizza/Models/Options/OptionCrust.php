<?php

namespace App\Pizza\Models\Options;

use App\Shared\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class OptionCrust extends Model
{
    use BaseOption;
    use Sluggable;
}
