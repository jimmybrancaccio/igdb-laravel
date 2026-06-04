<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Models;

class Company extends Model
{
    protected array $casts = [
        'changed_company_id' => self::class,
        'company_size' => CompanySize::class,
        'company_status' => CompanyStatus::class,
        'company_type' => CompanyType::class,
        'developed' => Game::class,
        'logo' => CompanyLogo::class,
        'parent' => self::class,
        'published' => Game::class,
        'size' => CompanySize::class,
        'status' => CompanyStatus::class,
        'type' => CompanyType::class,
        'websites' => CompanyWebsite::class,
    ];
}
