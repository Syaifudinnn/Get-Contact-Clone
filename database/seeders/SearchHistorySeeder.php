<?php

namespace Database\Seeders;

use App\Models\SearchHistory;
use Illuminate\Database\Seeder;

class SearchHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SearchHistory::factory()->count(10)->create();
    }
}
