<?php

namespace Ilyasdiker\LaravelAvailabilities\Models;

use Ilyasdiker\LaravelAvailabilities\Models\Availability;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Availability::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'day_of_week' => $this->faker->numberBetween(0, 6),
            'start_time' => $this->faker->numberBetween(0, 12).':00',
            'end_time' => $this->faker->numberBetween(13, 24).':00',
            'slot_duration' => $this->faker->numberBetween(30, 60)
        ];
    }
}
 