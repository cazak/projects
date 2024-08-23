<?php

declare(strict_types=1);

namespace App\Developer\Command\TransferToProject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class TransferToProjectCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $developerId,
        #[Assert\NotBlank]
        public string $projectName,
    ) {}
}
