<?php

declare(strict_types=1);

namespace App\Project\Query\AverageAgeOfDevelopersByProject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetAverageAgeOfDevelopersByProjectQuery
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $projectId,
    ) {}
}
