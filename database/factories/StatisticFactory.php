<?php

namespace Database\Factories;

use App\Models\Site;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Random\RandomException;

/**
 * @extends Factory<Site>
 */
class StatisticFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Statistic::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws RandomException
     */
    public function definition(): array
    {
        return [
            'collected_at' => time(),
            'collected_date' => date('Y-m-d'),
            'impressions' => random_int(1, 1000),
            'revenue' => $this->faker->randomFloat(2, 0, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
