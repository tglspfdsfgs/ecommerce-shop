<?php

namespace App\Pizza\Models\Options;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OptionRestriction extends Model
{
    protected $fillable = [
        'parent_type',
        'parent_id',
        'child_type',
        'child_id',
    ];

    public function parent(): MorphTo
    {
        return $this->morphTo();
    }

    public function child(): MorphTo
    {
        return $this->morphTo();
    }
}
