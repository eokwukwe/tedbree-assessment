<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Full-time', 'Temporary', 'Contract',
            'Permanent', 'Internship', 'Volunteer'
        ];

        foreach ($types as $type) {
            Type::create(['name' => $type]);
        }
    }
}
