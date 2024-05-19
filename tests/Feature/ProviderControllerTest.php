<?php

namespace Tests\Feature;

use App\Models\Provider;
use App\Models\Site;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Random\RandomException;
use Tests\TestCase;

class ProviderControllerTest extends TestCase
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
            ->get(route('providers.index'));

        $response->assertStatus(200);
    }

    public function testShow(): void
    {
        $provider = Provider::factory()->create();

        $response = $this
            ->withHeader('Authorization', $this->token)
            ->get(route('providers.show', ['provider' => $provider->id]));

        $response->assertStatus(200);
    }

    /**
     * @throws RandomException
     */
    public function testStore(): void
    {
        $providerName = 'Test Provider - ' . random_int(1, 100000);
        $response = $this
            ->withHeader('Authorization', $this->token)
            ->post(route('providers.store'), [
                'name' => $providerName,
                'tech_name' => Str::ucfirst(Str::camel($providerName)),
                'active' => 0,
            ]);

        $response->assertStatus(200);
    }

    public function testUpdate(): void
    {
        $provider = Provider::factory()->create([
            'active' => 1,
        ]);

        $response = $this
            ->withHeader('Authorization', $this->token)
            ->put(
                route('providers.update', [
                    'provider' => $provider->id,
                ]),
                [
                    'active' => 0,
                ]
            );

        $this->assertEquals(0, $provider->refresh()->active);
        $response->assertStatus(200);
    }

    public function testDelete(): void
    {
        $provider = Provider::factory()->create();

        $response = $this
            ->withHeader('Authorization', $this->token)
            ->delete(route('providers.destroy', ['provider' => $provider->id]));

        $this->assertModelMissing($provider);
        $response->assertStatus(204);
    }

    public function testAttachSite(): void
    {
        $provider = Provider::factory()->create();
        $site = Site::factory()->create();
        $response = $this
            ->withHeader('Authorization', $this->token)
            ->post(
                route('providers.sites.attach', [
                    'provider' => $provider->id,
                ]),
                [
                    'site_id' => $site->id,
                    'active' => 1,
                    'external_id' => Str::uuid()->toString(),
                ]
            );

        $response->assertStatus(204);
    }

    public function testDetachSite(): void
    {
        $provider = Provider::factory()->create();
        $site = Site::factory()->create();
        $provider->sites()->attach($site->id, [
            'active' => 1,
            'external_id' => Str::uuid()->toString()
        ]);
        $response = $this
            ->withHeader('Authorization', $this->token)
            ->delete(
                route('providers.sites.detach', [
                    'provider' => $provider->id,
                    'site' => $site->id,
                ])
            );

        $response->assertStatus(204);
    }
}
