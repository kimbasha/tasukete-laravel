<?php

namespace Tests\Feature;

use App\Models\Performance;
use App\Models\Troupe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerformanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 公演一覧ページが正しく表示されることをテスト
     */
    public function test_index_page_displays_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Performances/Index')
            ->has('performances')
        );
    }

    /**
     * 公演一覧に今日以降の公演のみが表示されることをテスト
     */
    public function test_index_page_shows_only_future_performances(): void
    {
        $troupe = Troupe::factory()->create();

        // 過去の公演
        Performance::factory()->create([
            'troupe_id' => $troupe->id,
            'performance_date' => now()->subDays(1),
        ]);

        // 今日の公演
        $todayPerformance = Performance::factory()->create([
            'troupe_id' => $troupe->id,
            'performance_date' => now(),
        ]);

        // 未来の公演
        $futurePerformance = Performance::factory()->create([
            'troupe_id' => $troupe->id,
            'performance_date' => now()->addDays(1),
        ]);

        $response = $this->get('/');

        $response->assertInertia(fn ($page) => $page
            ->component('Performances/Index')
            ->has('performances', 2)
            ->where('performances.0.id', $todayPerformance->id)
            ->where('performances.1.id', $futurePerformance->id)
        );
    }

    /**
     * 公演詳細ページが正しく表示されることをテスト
     */
    public function test_show_page_displays_successfully(): void
    {
        $troupe = Troupe::factory()->create([
            'name' => '劇団テスト',
            'description' => 'テスト用の劇団です',
        ]);

        $performance = Performance::factory()->create([
            'troupe_id' => $troupe->id,
            'title' => 'テスト公演',
            'description' => 'テスト用の公演です',
        ]);

        $response = $this->get("/performances/{$performance->id}");

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('Performances/Show')
            ->has('performance')
            ->where('performance.id', $performance->id)
            ->where('performance.title', 'テスト公演')
            ->where('performance.troupe.name', '劇団テスト')
        );
    }

    /**
     * 存在しない公演IDで404が返されることをテスト
     */
    public function test_show_page_returns_404_for_nonexistent_performance(): void
    {
        $response = $this->get('/performances/999');

        $response->assertStatus(404);
        $response->assertInertia(fn ($page) => $page
            ->component('Errors/NotFound')
        );
    }

    /**
     * 公演データの構造が正しいことをテスト
     */
    public function test_performance_data_structure_is_correct(): void
    {
        $troupe = Troupe::factory()->create();
        $performance = Performance::factory()->create([
            'troupe_id' => $troupe->id,
            'has_day_tickets' => true,
        ]);

        $response = $this->get('/');

        $response->assertInertia(fn ($page) => $page
            ->component('Performances/Index')
            ->has('performances.0', fn ($performance) => $performance
                ->has('id')
                ->has('title')
                ->has('troupe_name')
                ->has('venue')
                ->has('area')
                ->has('performance_date')
                ->has('start_time')
                ->has('ticket_price')
                ->has('has_day_tickets')
                ->has('poster_image_url')
            )
        );
    }
}
