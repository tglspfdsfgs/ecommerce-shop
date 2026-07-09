<?php

namespace App\Pizza\Models\Options;

use App\Shared\Models\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

abstract class Option extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'slug', 'sort_order'];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (null === $model->sort_order) {
                $model->sort_order =
                    (static::max('sort_order') ?? 0) + 1;
            }
        });
    }

    /**
     * Returns the child option restrictions for this option.
     *
     * @return MorphMany<OptionRestriction, static>
     */
    public function restrictions(): MorphMany
    {
        return $this->morphMany(
            OptionRestriction::class,
            'parent'
        );
    }

    /**
     * Prevents the specified child option from being used with this option.
     */
    public function restrict(Option $child): void
    {
        $this->restrictions()->create([
            'child_type' => $child->getMorphClass(),
            'child_id' => $child->getKey(),
        ]);
    }
}
