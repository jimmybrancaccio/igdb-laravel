<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Models;

class Platform extends Model
{
    protected array $casts = [
        'category' => PlatformType::class,
        'platform_family' => PlatformFamily::class,
        'platform_logo' => PlatformLogo::class,
        'platform_type' => PlatformType::class,
        'versions' => PlatformVersion::class,
        'websites' => PlatformWebsite::class,
    ];
}
