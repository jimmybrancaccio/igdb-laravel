<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Models;

class CompanyTypeHistory extends Model
{
    protected array $casts = [
        'company' => Company::class,
        'company_type' => CompanyType::class,
        'parent_company' => Company::class,
    ];
}
