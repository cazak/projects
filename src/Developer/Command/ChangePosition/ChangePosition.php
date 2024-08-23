<?php

declare(strict_types=1);

namespace App\Developer\Command\ChangePosition;

use App\Developer\Entity\DeveloperRepository;
use App\Developer\Entity\ValueObject\Position;
use Doctrine\ORM\EntityManagerInterface;

final readonly class ChangePosition
{
    public function __construct(
        private DeveloperRepository $developerRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(ChangePositionCommand $command): void
    {
        $developer = $this->developerRepository->get($command->developerId);

        $developer->changePosition(Position::from($command->position));

        $this->entityManager->flush();
    }
}
