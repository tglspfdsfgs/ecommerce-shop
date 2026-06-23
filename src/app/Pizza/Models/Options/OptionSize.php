<?php

namespace App\Pizza\Models\Options;

use App\Shared\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;

class OptionSize extends Model
{
    use BaseOption;
    use Sluggable;
}
