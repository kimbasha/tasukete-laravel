<?php

namespace Tests\Unit\Models;

use App\Models\Performance;
use App\Models\Troupe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerformanceModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 公演が劇団に属することをテスト
     */
    public function test_performance_belongs_to_troupe(): void
    {
        $troupe = Troupe::factory()->create(['name' => '劇団テスト']);
        $performance = Performance::factory()->create(['troupe_id' => $troupe->id]);

        $this->assertInstanceOf(Troupe::class, $performance->troupe);
        $this->assertEquals('劇団テスト', $performance->troupe->name);
    }

    /**
     * 公演の日付がdateにキャストされることをテスト
     */
    public function test_performance_date_is_cast_to_date(): void
    {
        $performance = Performance::factory()->create([
            'performance_date' => '2025-12-31',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $performance->performance_date);
        $this->assertEquals('2025-12-31', $performance->performance_date->format('Y-m-d'));
    }

    /**
     * 当日券の有無がbooleanにキャストされることをテスト
     */
    public function test_has_day_tickets_is_cast_to_boolean(): void
    {
        $performance = Performance::factory()->create(['has_day_tickets' => true]);

        $this->assertIsBool($performance->has_day_tickets);
        $this->assertTrue($performance->has_day_tickets);
    }

    /**
     * 公演の必須フィールドが正しく設定されることをテスト
     */
    public function test_performance_fillable_attributes(): void
    {
        $troupe = Troupe::factory()->create();
        $performance = Performance::factory()->create([
            'troupe_id' => $troupe->id,
            'title' => 'テスト公演',
            'venue' => 'テスト会場',
            'area' => '新宿',
            'ticket_price' => 3000,
        ]);

        $this->assertEquals('テスト公演', $performance->title);
        $this->assertEquals('テスト会場', $performance->venue);
        $this->assertEquals('新宿', $performance->area);
        $this->assertEquals(3000, $performance->ticket_price);
    }
}
