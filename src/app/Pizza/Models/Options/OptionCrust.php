<?php

namespace App\Pizza\Models\Options;

use Illuminate\Database\Eloquent\Relations\MorphMany;

class OptionCrust extends Option
{
    public function restrictions(): MorphMany
    {
        throw new \BadMethodCallException('Crusts have no dependent options to restrict.');
    }
}
