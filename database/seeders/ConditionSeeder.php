<?php

namespace Database\Seeders;

use App\Models\Condition;
use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditions = ['Remote', 'Part Remote', 'On-Premise'];

        foreach ($conditions as $condition) {
            Condition::create(['name' => $condition]);
        }
    }
}
