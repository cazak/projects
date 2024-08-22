<?php

declare(strict_types=1);

namespace App\Project\Command\Create;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateProjectCommand
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $clientName,
    ) {}
}
