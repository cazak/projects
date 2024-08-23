<?php

declare(strict_types=1);

namespace App\Developer\Command\HireToProject;

use App\Developer\Entity\DeveloperRepository;
use App\Project\Entity\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class HireToProject
{
    public function __construct(
        private ProjectRepository $projectRepository,
        private DeveloperRepository $developerRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(HireToProjectCommand $command): void
    {
        $project = $this->projectRepository->getByName($command->projectName);
        $developer = $this->developerRepository->get($command->developerId);

        $developer->hireToProject($project);
        $this->entityManager->flush();
    }
}
