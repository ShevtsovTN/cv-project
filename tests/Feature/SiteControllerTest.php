<?php

namespace Tests\Feature;

use App\Models\Provider;
use App\Models\Site;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Random\RandomException;
use Tests\TestCase;

class SiteControllerTest extends TestCase
{
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
        $response = $this
            ->withHeader('Authorization', $this->token)
            ->get(route('sites.index'));

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
        $response = $this
            ->withHeader('Authorization', $this->token)
            ->post(route('sites.store'), [
                'name' => 'Test Site - ' . random_int(1, 100000),
                'url' => 'https://test-site-' . random_int(1, 10000) . '.com',
                'provider_key' => Str::uuid()->toString(),
            ]);

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
