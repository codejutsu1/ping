<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Check;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'url' => $this->faker->url(),
            'content_type' => $this->faker->mimeType(),
            'status' => Response::HTTP_OK,
            'header_size' => 0,
            'request_size' => 0,
            'redirect_count' => 0,
            'http_version' => 0,
            'appconnect_time' => 0,
            'connect_time' => 0,
            'namelookup_time' => 0,
            'pretransfer_time' => 0,
            'redirect_time' => 0,
            'starttransfer_time' => 0,
            'total_time' => 0,
            'check_id' => Check::factory(),
            'start_at' => $start = Carbon::parse(
                time: $this->faker->dateTimeThisMonth(), 
            ),
            'finished_at' => $start->addSeconds(
                value: $this->faker->numberBetween(int2: 4)
            ),
        ];
    }
}
