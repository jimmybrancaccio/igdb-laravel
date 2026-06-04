<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Exceptions\AuthenticationException;
use Throwable;

/**
 * @internal
 */
final class Client
{
    public static function get(string $endpoint, string $query, int $cacheLifetime): mixed
    {
        $cacheKey = self::handleCache($endpoint, $query, $cacheLifetime);

        return Cache::remember($cacheKey, $cacheLifetime, static fn () => self::request($endpoint, $query));
    }

    public static function count(string $endpoint, string $query, int $cacheLifetime): int
    {
        $endpoint = Str::finish($endpoint, '/count');
        $cacheKey = self::handleCache($endpoint, $query, $cacheLifetime);

        return Cache::remember($cacheKey, $cacheLifetime, static function () use ($endpoint, $query): int {
            $response = self::request($endpoint, $query);
            if (is_array($response)) {
                return (int) $response['count'];
            }

            return 0;
        });
    }

    public static function multiQuery(string $query, int $cacheLifetime): mixed
    {
        $cacheKey = self::handleCache('multiquery', $query, $cacheLifetime);

        return Cache::remember($cacheKey, $cacheLifetime, static fn () => self::request('multiquery', $query));
    }

    public static function pendingRequest(): PendingRequest
    {
        return Http::withOptions([
            'base_uri' => ApiHelper::IGDB_BASE_URI,
        ])->withHeaders([
            'Accept' => 'application/json',
            'Client-ID' => config('igdb.credentials.client_id'),
            'Authorization' => 'Bearer ' . ApiHelper::retrieveAccessToken(),
        ]);
    }

    private static function handleCache(string $endpoint, string $query, int $cacheLifetime): string
    {
        $key = config('igdb.cache_prefix', 'igdb_cache') . '.' . md5($endpoint . $query);

        if ($cacheLifetime === 0) {
            Cache::forget($key);
        }

        return $key;
    }

    /**
     * @throws AuthenticationException
     * @throws RequestException
     */
    private static function request(string $endpoint, string $query): mixed
    {
        return self::pendingRequest()
            ->withBody($query, 'text/plain')
            ->retry(3, 250, static fn (Throwable $exception, PendingRequest $request, ?string $verb): bool => !$exception instanceof RequestException || $exception->response->status() === 429)
            ->post($endpoint)
            ->throw()
            ->json();
    }
}
