<?php

namespace Tests\Feature;

use App\DTO\SiteForProviderDTO;
use App\Models\Provider;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Random\RandomException;
use Tests\TestCase;

class ProviderOneStatisticCommandTest extends TestCase
{
    use RefreshDatabase;

    private string $providerName;

    protected function setUp(): void
    {
        parent::setUp();
        $this->providerName = 'ProviderOne';
    }

    /**
     * A basic feature test example.
     * @throws RandomException
     */
    public function testCommand(): void
    {
        /** @var Provider $provider */
        $provider = Provider::factory()->create([
            'name' => $this->providerName,
            'tech_name' => Str::ucfirst(Str::camel($this->providerName)),
            'active' => true,
        ]);

        /** @var Site $site */
        $site = Site::factory()->create([
            'name' => 'Random Site - ' . random_int(1, 100),
            'url' => 'https://random-site.com',
            'provider_key' => Str::uuid()->toString(),
        ]);

        $provider->sites()->attach($site, [
            'active' => true,
            'external_id' => Str::uuid()->toString(),
        ]);

        $sites = $provider->sites
            ->map(fn(Site $site) => new SiteForProviderDTO([
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
