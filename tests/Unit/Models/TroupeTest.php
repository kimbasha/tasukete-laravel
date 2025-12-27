<?php

namespace Tests\Unit\Models;

use App\Models\Performance;
use App\Models\Troupe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TroupeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 劇団が複数の公演を持つことができることをテスト
     */
    public function test_troupe_has_many_performances(): void
    {
        $troupe = Troupe::factory()->create();
        Performance::factory()->count(3)->create(['troupe_id' => $troupe->id]);

        $this->assertCount(3, $troupe->performances);
        $this->assertInstanceOf(Performance::class, $troupe->performances->first());
    }

    /**
     * 劇団の必須フィールドが正しく設定されることをテスト
     */
    public function test_troupe_fillable_attributes(): void
    {
        $troupe = Troupe::factory()->create([
            'name' => 'テスト劇団',
            'description' => 'テスト用の説明',
            'website' => 'https://example.com',
        ]);

        $this->assertEquals('テスト劇団', $troupe->name);
        $this->assertEquals('テスト用の説明', $troupe->description);
        $this->assertEquals('https://example.com', $troupe->website);
    }
}
