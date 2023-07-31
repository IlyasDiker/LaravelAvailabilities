<?php

namespace Ilyasdiker\LaravelAvailabilities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ilyasdiker\LaravelAvailabilities\Services\AvailabilityService;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'slot_duration',
    ];

    public function available()
    {
        return $this->morphTo();
    }

    public function slotsAttribute()
    {
        return AvailabilityService::generateAvailabilitySlots($this);
    }
}
