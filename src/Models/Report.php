<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Models;

class Report extends Model
{
    protected array $casts = [
        'type' => ReportType::class,
    ];
}
