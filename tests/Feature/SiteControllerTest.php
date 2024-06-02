<?php

namespace Tests\Feature;

use App\Models\Provider;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Random\RandomException;
use Tests\TestCase;

class SiteControllerTest extends TestCase
{
    use RefreshDatabase;

    public string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->token = Hash::make(config('api.auth_key'), [
            'rounds' => 12,
        ]);
    }

    public function testIndex(): void
    {
        $site = Site::factory()->create();

        $response = $this
            ->withHeader('Authorization', $this->token)
            ->get(route('sites.index'));

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'url',
                    'provider_key',
                    'created_at',
                    'updated_at',
                ],
            ]
        ]);

        $siteIdFromResponse = $response['data'][0]['id'];
        $this->assertModelExists(
            Site::query()->find($siteIdFromResponse)
        );
        $this->assertEquals($site->id, $siteIdFromResponse);
        $response->assertStatus(200);
    }

    public function testShow(): void
    {
        $site = Site::factory()->create();

        $response = $this
            ->withHeader('Authorization', $this->token)
            ->get(route('sites.show', ['site' => $site->id]));

        $response->assertStatus(200);
    }

    /**
     * @throws RandomException
     */
    public function testStore(): void
    {
        $url = 'https://test-site-' . random_int(1, 10000) . '.com';
        $name = 'Test Site - ' . random_int(1, 100000);
        $providerKey = Str::uuid()->toString();
        $response = $this
            ->withHeader('Authorization', $this->token)
            ->post(route('sites.store'), [
                'name' => $name,
                'url' => $url,
                'provider_key' => $providerKey,
            ]);

        $this->assertModelExists(
            Site::query()->where([
                'name' => $name,
                'url' => $url,
                'provider_key' => $providerKey,
            ])->first()
        );
        $response->assertStatus(200);
    }

    /**
     * @throws RandomException
     */
    public function testUpdate(): void
    {
        $name = 'Test Site - ' . random_int(1, 100000);
        $site = Site::factory()->create([
            'name' => $name,
        ]);

        $response = $this
            ->withHeader('Authorization', $this->token)
            ->put(
                route('sites.update', [
                    'site' => $site->id,
                ]),
                [
                    'name' => $name.'-updated',
                ]
            );

        $this->assertEquals($name.'-updated', $site->refresh()->name);
        $response->assertStatus(200);
    }

    public function testDelete(): void
    {
        $site = Site::factory()->create();

        $response = $this
            ->withHeader('Authorization', $this->token)
            ->delete(route('sites.destroy', ['site' => $site->id]));

        $this->assertModelMissing($site);
        $response->assertStatus(204);
    }

    public function testUpdateProviderSiteFields(): void
    {
        $site = Site::factory()->create();
        $provider = Provider::factory()->create();

        $site->providers()->attach($provider, [
            'active' => true,
            'external_id' => Str::uuid()->toString()
        ]);

        $newExternalId = Str::uuid()->toString();
        $response = $this
            ->withHeader('Authorization', $this->token)
            ->patch(
                route('sites.providers.update-fields', [
                    'site' => $site->id,
                    'provider' => $provider->id,
                ]),
                [
                    'active' => false,
                    'external_id' => $newExternalId
                ]
            );

        $this->assertEquals(0, $site->providers->first()->pivot->active);
        $this->assertEquals($newExternalId, $site->providers->first()->pivot->external_id);
        $response->assertStatus(204);
    }
}
