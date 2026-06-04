<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Models;

class Website extends Model
{
    protected array $casts = [
        'category' => WebsiteType::class,
        'game' => Game::class,
        'type' => WebsiteType::class,
    ];
}
