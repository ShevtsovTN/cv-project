<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Site;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProviderSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var Provider $providerOne */
        $providerOne = Provider::query()
            ->where('name', 'Provider One')->first();

        /** @var Provider $providerTwo */
        $providerTwo = Provider::query()
            ->where('name', 'Provider Two')->first();

        $sites = Site::query();

        foreach ($sites->cursor() as $site) {
            $providerOne->sites()->attach($site->id, [
                'active' => true,
                'external_id' => Str::uuid()->toString(),
            ]);

            $providerTwo->sites()->attach($site->id, [
                'active' => true,
                'external_id' => Str::uuid()->toString(),
            ]);
        }
    }
}
