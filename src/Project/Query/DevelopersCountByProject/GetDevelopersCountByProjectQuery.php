<?php

declare(strict_types=1);

namespace App\Project\Query\DevelopersCountByProject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class GetDevelopersCountByProjectQuery
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $projectId,
    ) {}
}
