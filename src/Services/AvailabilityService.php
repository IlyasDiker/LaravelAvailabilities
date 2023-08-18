<?php

namespace Ilyasdiker\LaravelAvailabilities\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Ilyasdiker\LaravelAvailabilities\Models\Availability;

class AvailabilityService
{
    /**
     * Generate availability slots based on availability.
     *
     * @param  Availability  $availability one single availability
     */
    public static function generateAvailabilitySlots(Availability $availability): array
    {
        $availabilities = [];
        $currentTime = Carbon::parse($availability->start_time);
        $endTime = Carbon::parse($availability->end_time);
        $slotDuration = $availability->slot_duration;

        while ($currentTime->copy()->addMinutes($slotDuration) <= $endTime) {
            if(count($availabilities) > 0){
                $currentTime->addMinutes(1);
            }
            $availability = [
                'start_time' => $currentTime->toTimeString(),
                'end_time' => $currentTime->addMinutes($slotDuration)->toTimeString(),
                'slot_duration' => $slotDuration,
            ];

            $availabilities[] = $availability;
        }

        return $availabilities;
    }

    /**
     * Generate availabilities slots based on availabilities.
     * Better to use with only same day availabilities
     */
    public static function generateSameDayAvailabilitiesSlots($availabilities): Collection
    {
        $availabilitiesSlots = collect([]);
        foreach ($availabilities as $key => $availability) {
            $dayAvailabilitySlots = self::generateAvailabilitySlots($availability);
            $availabilitiesSlots = $availabilitiesSlots->merge($dayAvailabilitySlots);
        }

        return $availabilitiesSlots;
    }

    /*
    * Useleess function to delete if not needed
    */
    public static function saveAvailabilities(array $availabilities, $available)
    {
        $createdAvailabilities = $available->availabilities()->save($availabilities);

        return $createdAvailabilities;
    }

    /**
     * Get availabilities for a specific date range.
     *
     * @param  object  $available
     */
    public static function getAvailabilitiesForDateRange($available, string $startDate, string $endDate): Collection|null
    {
        if (! $startDate || ! $endDate) {
            return null;
        }

        $slots = collect([]);
        $period = new CarbonPeriod($startDate, $endDate);
        $availabilities = $available->availabilities;

        foreach ($period as $key => $day) {
            $weekDayAvailabilities = $availabilities->where('day_of_week', $day->dayOfWeek);
            $weekDayAvailabilitySlots = self::generateSameDayAvailabilitiesSlots($weekDayAvailabilities);
            $slots->push(collect(
                [
                    'day' => $day,
                    'slots' => $weekDayAvailabilitySlots,
                ]
            ));
        }

        return $slots;
    }
}
