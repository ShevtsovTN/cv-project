<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Provider::factory()->create([
            'name' => 'Provider One',
            'tech_name' => Str::ucfirst(Str::camel('Provider One'))
        ]);
        Provider::factory()->create([
            'name' => 'Provider Two',
            'tech_name' => Str::ucfirst(Str::camel('Provider Two'))
        ]);
        Provider::factory()->count(10)->create();
    }
}
