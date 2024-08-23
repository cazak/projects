<?php

declare(strict_types=1);

namespace App\Developer\Command\HireToProject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class HireToProjectCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $developerId,
        #[Assert\NotBlank]
        public string $projectName,
    ) {}
}
