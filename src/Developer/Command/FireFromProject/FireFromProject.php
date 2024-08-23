<?php

declare(strict_types=1);

namespace App\Developer\Command\FireFromProject;

use App\Developer\Entity\DeveloperRepository;
use App\Project\Entity\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class FireFromProject
{
    public function __construct(
        private ProjectRepository $projectRepository,
        private DeveloperRepository $developerRepository,
        private EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(FireFromProjectCommand $command): void
    {
        $project = $this->projectRepository->getByName($command->projectName);
        $developer = $this->developerRepository->get($command->developerId);

        $developer->fireFromProject($project);
        $this->entityManager->flush();
    }
}
