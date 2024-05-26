<?php

namespace Tests\Feature;

use App\DTO\SiteForProviderDTO;
use App\Models\Provider;
use Illuminate\Support\Facades\Http;
use Random\RandomException;
use Tests\TestCase;

class ProviderOneStatisticCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     * @throws RandomException
     */
    public function testCommand(): void
    {
        $provider = Provider::query()
            ->where('name', 'Provider One')
            ->with('sites')
            ->get();

        $sites = $provider->flatMap(function ($provider) {
            return $provider->sites;
        })->map(fn ($site) => new SiteForProviderDTO([
            'id' => $site->id,
            'external_id' => $site->pivot->external_id,
        ]));

        $urlResponses = [];

        foreach ($sites as $site) {
            $temp = [
                $site->external_id => [
                    'Date' => now()->format('Y-m-d'),
                    'SiteImpressions' => random_int(1, 10000),
                    'SiteRevenue' => 0.1,
                ]
            ];
            $urlResponses['*/' . $site->external_id . '*'] = Http::response($temp);
        }

        Http::preventStrayRequests();

        Http::fake($urlResponses);

        $this
            ->artisan('app:get-provider-one-statistic-command')
            ->assertExitCode(0);

        Http::assertSentCount(count($sites));
    }
}
