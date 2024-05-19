<?php

namespace Tests\Feature;

use App\DTO\StatisticSiteDTO;
use App\Models\Provider;
use Illuminate\Support\Facades\Http;
use Random\RandomException;
use Tests\TestCase;

class ProviderTwoStatisticCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     * @throws RandomException
     */
    public function testCommand(): void
    {
        $provider = Provider::query()
            ->where('name', 'Provider Two')
            ->with('sites')
            ->get();

        $sites = $provider->flatMap(function ($provider) {
            return $provider->sites;
        })->map(fn ($site) => new StatisticSiteDTO([
            'id' => $site->id,
            'external_id' => $site->pivot->external_id,
        ]));

        $data = [];

        foreach ($sites as $site) {
            $data[] = [
                'Id' => $site->external_id,
                'DateTime' => now()->format('Y-m-d H:i:s'),
                'Imp' => random_int(1, 10000),
                'Rev' => 0.1,
            ];
        }

        Http::preventStrayRequests();

        Http::fake([
            '*/auth' => Http::response([
                'token' => 'example_token'
            ]),
            '*/stat/sites' => Http::response([
                'data' => $data
            ]),
        ]);

        $this
            ->artisan('app:get-provider-two-statistic-command')
            ->assertExitCode(0);

        Http::assertSentCount(1);
    }
}
