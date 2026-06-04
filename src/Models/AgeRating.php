<?php

declare(strict_types=1);

namespace MarcReichel\IGDBLaravel\Models;

class AgeRating extends Model
{
    protected array $casts = [
        'organization' => AgeRatingOrganization::class,
        'rating_category' => AgeRatingCategory::class,
        'content_descriptions' => AgeRatingContentDescription::class,
        'rating_content_descriptions' => AgeRatingContentDescriptionV2::class,
    ];
}
