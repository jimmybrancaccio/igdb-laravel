<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Models;

class ReleaseDate extends Model
{
    protected array $casts = [
        'category' => ReleaseDateRegion::class,
        'game' => Game::class,
        'platform' => Platform::class,
        'region' => ReleaseDateRegion::class,
        'status' => ReleaseDateStatus::class,
    ];
}
