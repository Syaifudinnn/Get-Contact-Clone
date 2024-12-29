<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Client;
use App\Models\SpamReport;

class SpamReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SpamReport::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'phone_number' => $this->faker->phoneNumber(),
            'reason' => $this->faker->text(),
            'client_id' => Client::factory(),
        ];
    }
}
