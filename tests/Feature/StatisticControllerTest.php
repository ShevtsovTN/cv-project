<?php

namespace Tests\Feature;

use App\Models\Provider;
use App\Models\Site;
use App\Models\Statistic;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Random\RandomException;
use Tests\TestCase;

class StatisticControllerTest extends TestCase
{
    public string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->token = Hash::make(config('api.auth_key'), [
            'rounds' => 12,
        ]);
    }

    /**
     * @throws RandomException
     */
    public function testIndexBySite(): void
    {
        /** @var Provider $provider */
        $provider = Provider::query()
            ->with(['sites' => function ($query) {
                $query->wherePivot('active', true);
            }])
            ->where('tech_name', 'ProviderOne')
            ->first();

        /** @var Site $site */
        $site = $provider->sites->first();

        /** @var Statistic $statisticObj */
        $statisticObj = Statistic::query()->firstOrCreate(
            [
                'site_id' => $provider->id,
                'provider_id' => $site->id,
            ],
            [
                'collected_at' => time(),
                'collected_date' => date('Y-m-d'),
                'impressions' => random_int(1, 1000),
                'revenue' => random_int(1, 1000),
            ]
        );

        $response = $this
            ->withHeader('Authorization', $this->token)
            ->get(route('statistics.site', ['site' => $site->id]));

        $this->assertContains($statisticObj->id, data_get($response['data'], '*.id'));
        $response->assertStatus(200);
    }

    /**
     * @throws RandomException
     */
    public function testIndexByProvider(): void
    {
        /** @var Provider $provider */
        $provider = Provider::query()
            ->with(['sites' => function ($query) {
                $query->wherePivot('active', true);
            }])
            ->where('tech_name', 'ProviderOne')
            ->first();

        /** @var Site $site */
        $site = $provider->sites->first();

        /** @var Statistic $statisticObj */
        $statisticObj = Statistic::query()->firstOrCreate(
            [
                'site_id' => $provider->id,
                'provider_id' => $site->id,
            ],
            [
                'collected_at' => time(),
                'collected_date' => date('Y-m-d'),
                'impressions' => random_int(1, 1000),
                'revenue' => random_int(1, 1000),
            ]
        );

        $response = $this
            ->withHeader('Authorization', $this->token)
            ->get(route('statistics.provider', ['provider' => $provider->id]));

        $this->assertContains($statisticObj->id, data_get($response['data'], '*.id'));
        $response->assertStatus(200);
    }
}
