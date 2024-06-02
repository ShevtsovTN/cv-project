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

class ProviderTwoStatisticCommandTest extends TestCase
{
    use RefreshDatabase;

    private string $providerName;

    protected function setUp(): void
    {
        parent::setUp();
        $this->providerName = 'ProviderTwo';
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

        Http::assertSentCount(2);
    }
}
