<?php

namespace Ilyasdiker\LaravelAvailabilities;

use Ilyasdiker\LaravelAvailabilities\Models\Availability;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAvailabilities
{
    public function availabilities(): MorphMany
    {
        return $this->morphMany(Availability::class, 'available');
    }
}
