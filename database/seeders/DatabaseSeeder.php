<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 劇団を作成
        $troupe1 = \App\Models\Troupe::create([
            'name' => '劇団シェイクスピア',
            'description' => 'クラシック演劇を専門とする劇団',
            'website' => 'https://example.com/shakespeare',
        ]);

        $troupe2 = \App\Models\Troupe::create([
            'name' => 'Theatre Company SUBARU',
            'description' => '現代演劇を中心に活動',
            'website' => 'https://example.com/subaru',
        ]);

        // 公演を作成
        \App\Models\Performance::create([
            'troupe_id' => $troupe1->id,
            'title' => '夏の夜の夢',
            'description' => 'シェイクスピアの名作',
            'venue' => '下北沢タイニイアリス',
            'area' => '下北沢',
            'performance_date' => '2025-12-26',
            'start_time' => '19:00',
            'ticket_price' => 3500,
            'has_day_tickets' => true,
            'status' => 'today',
        ]);

        \App\Models\Performance::create([
            'troupe_id' => $troupe2->id,
            'title' => '待ちぼうけ',
            'description' => 'オリジナル作品',
            'venue' => '新宿シアターサンモール',
            'area' => '新宿',
            'performance_date' => '2025-12-27',
            'start_time' => '14:00',
            'ticket_price' => 4000,
            'has_day_tickets' => false,
            'status' => 'upcoming',
        ]);
    }
}
