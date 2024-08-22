<?php

declare(strict_types=1);

namespace App\Developer\Command\Create;

use App\Developer\Entity\ValueObject\Position;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateDeveloperCommand
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $surname,
        #[Assert\NotBlank]
        public string $patronymic,
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,
        #[Assert\NotBlank]
        public string $phone,
        #[Assert\NotBlank]
        #[Assert\Choice(callback: [Position::class, 'casesAtString'])]
        public string $position,
    ) {}
}
