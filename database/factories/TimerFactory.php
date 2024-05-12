<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Timer;

class TimerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Timer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'startTime' => $this->faker->dateTime(),
            'endTime' => $this->faker->word(),
            'manualEntry' => $this->faker->boolean(),
            'updatedManually' => $this->faker->boolean(),
            'user_id' => $this->faker->word(),
            'project_id' => $this->faker->word(),
        ];
    }
}
