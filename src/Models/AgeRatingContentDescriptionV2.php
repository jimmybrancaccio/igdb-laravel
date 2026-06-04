<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Models;

class AgeRatingContentDescriptionV2 extends Model
{
    public const string ENDPOINT = 'age_rating_content_descriptions_v2';

    protected array $casts = [
        'organization' => AgeRatingOrganization::class,
        'type' => AgeRatingContentDescriptionType::class,
    ];
}
