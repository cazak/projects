<?php

declare(strict_types=1);

namespace App\Project\Command\Delete;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class DeleteProjectCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $projectId,
    ) {}
}
