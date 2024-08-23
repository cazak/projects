<?php

declare(strict_types=1);

namespace App\Developer\Command\ChangePosition;

use App\Developer\Entity\ValueObject\Position;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class ChangePositionCommand
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $developerId,
        #[Assert\NotBlank]
        #[Assert\Choice(callback: [Position::class, 'casesAtString'])]
        public string $position,
    ) {}
}
