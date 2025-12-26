<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Performance>
 */
class PerformanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $areas = ['下北沢', '新宿', '渋谷', '池袋', 'その他'];
        $venues = [
            '下北沢タイニイアリス',
            '新宿シアターサンモール',
            '渋谷公園通り劇場',
            '池袋シアターグリーン',
            '東京芸術劇場',
        ];

        return [
            'troupe_id' => \App\Models\Troupe::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->realText(200),
            'venue' => fake()->randomElement($venues),
            'area' => fake()->randomElement($areas),
            'performance_date' => fake()->dateTimeBetween('now', '+1 month'),
            'start_time' => fake()->time('H:i'),
            'door_open_time' => fake()->optional(0.7)->time('H:i'),
            'ticket_price' => fake()->numberBetween(2000, 5000),
            'has_day_tickets' => fake()->boolean(70),
            'poster_image_url' => fake()->optional(0.5)->imageUrl(400, 600),
            'reservation_url' => fake()->optional(0.8)->url(),
            'status' => fake()->randomElement(['today', 'upcoming', 'ended']),
        ];
    }
}
