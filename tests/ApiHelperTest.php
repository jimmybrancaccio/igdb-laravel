<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Tests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use MarcReichel\IGDBLaravel\ApiHelper;
use MarcReichel\IGDBLaravel\Exceptions\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal
 */
class ApiHelperTest extends TestCase
{
    /**
     * @throws AuthenticationException
     */
    public function testItShouldUseAccessTokenFromCache(): void
    {
        Cache::put('igdb_cache.access_token', 'some-token');

        $token = ApiHelper::retrieveAccessToken();

        $this->assertEquals('some-token', $token);
    }

    /**
     * @throws AuthenticationException
     */
    public function testItShouldRetrieveAccessTokenFromTwitch(): void
    {
        Cache::forget('igdb_cache.access_token');

        Http::fake([
            '*/oauth2/token*' => Http::response([
                'access_token' => 'test-suite-token',
                'expires_in' => 3600,
            ]),
        ]);

        $token = ApiHelper::retrieveAccessToken();

        $this->assertEquals('test-suite-token', $token);
    }

    /**
     * @throws AuthenticationException
     */
    public function testItShouldUseConfiguredCachePrefixForAccessToken(): void
    {
        Config::set('igdb.cache_prefix', 'custom_igdb_cache');
        Cache::forget('custom_igdb_cache.access_token');

        Http::fake([
            '*/oauth2/token*' => Http::response([
                'access_token' => 'prefixed-token',
                'expires_in' => 3600,
            ]),
        ]);

        $token = ApiHelper::retrieveAccessToken();

        $this->assertEquals('prefixed-token', $token);
        $this->assertEquals('prefixed-token', Cache::get('custom_igdb_cache.access_token'));
    }

    /**
     * @throws AuthenticationException
     */
    public function testItShouldClampShortAccessTokenLifetime(): void
    {
        Cache::forget('igdb_cache.access_token');

        Http::fake([
            '*/oauth2/token*' => Http::response([
                'access_token' => 'short-token',
                'expires_in' => 30,
            ]),
        ]);

        $token = ApiHelper::retrieveAccessToken();

        $this->assertEquals('short-token', $token);
        $this->assertEquals('short-token', Cache::get('igdb_cache.access_token'));
    }

    /**
     * @throws AuthenticationException
     */
    public function testItShouldThrowAuthenticationException(): void
    {
        $this->expectException(AuthenticationException::class);

        Cache::forget('igdb_cache.access_token');

        Http::fake([
            '*/oauth2/token*' => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR),
        ]);

        ApiHelper::retrieveAccessToken();
    }
}
